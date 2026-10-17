import fs from 'node:fs';
import path from 'node:path';
import { parseArgs } from 'node:util';
import slugify from 'slugify';
import MarkdownIt from 'markdown-it';
import sharp from 'sharp';
import handlebars from 'handlebars';
import handlebarsLayouts from 'handlebars-layouts';
import * as sass from 'sass';

type Dimensions = { width: number; height: number };

type Post = {
    slug: string;
    title: string;
    date: Date;
    hero: string;
    heroAlt: string;
    intro: string;
    html: string;
};

const siteUrl = 'https://www.joelgonewild.com';
const siteDescription = 'I really enjoy exploring new places, so in 2014 I started writing down the things I had done both for others to read, and so future me can read too!';
const imageSizes = [400, 800, 1200, 1600, 2000];
const imageFormats = ['jpg', 'avif'] as const;

const { values: args } = parseArgs({
    options: {
        post: { type: 'string' },
        'no-photos': { type: 'boolean', default: false },
    },
});

const markdown = new MarkdownIt({ html: true });

const monthYear = new Intl.DateTimeFormat('en-GB', { month: 'long', year: 'numeric', timeZone: 'UTC' });

const srcset = (slug: string, name: string, format: string) => {
    return imageSizes.map((size) => `/${slug}/${name}-${size}.${format} ${size}w`).join(', ');
};

handlebars.registerHelper(handlebarsLayouts(handlebars));
handlebars.registerHelper('date', (date: Date) => monthYear.format(date));
handlebars.registerHelper('rfc822', (date: Date) => date.toUTCString());
handlebars.registerHelper('srcset', srcset);

handlebars.registerPartial('layout', fs.readFileSync('./src/templates/layout.hbs', 'utf8'));

const compileTemplate = (name: string) => handlebars.compile(fs.readFileSync(`./src/templates/${name}.hbs`, 'utf8'));
const homeTemplate = compileTemplate('home');
const postTemplate = compileTemplate('post');
const feedTemplate = compileTemplate('feed');
const sitemapTemplate = compileTemplate('sitemap');

const makeDirectoryExist = (directoryPath: string) => {
    if (!fs.existsSync(directoryPath)) {
        fs.mkdirSync(directoryPath);
    }
};

const makeSlug = (string: string) => {
    return slugify(string, {
        lower: true,
    });
};

const directoryContents = (rootPath: string, filter: (itemPath: string) => boolean) => {
    return fs.readdirSync(rootPath).map((item) => path.join(rootPath, item)).filter(filter);
};

const directoriesIn = (rootPath: string) => {
    return directoryContents(rootPath, (itemPath) => fs.lstatSync(itemPath).isDirectory());
};

const imagesIn = (rootPath: string) => {
    return directoryContents(rootPath, (itemPath) => path.parse(itemPath).ext === '.jpg');
};

const photoDimensions = async (photoPath: string): Promise<Dimensions> => {
    const { autoOrient } = await sharp(photoPath).metadata();
    return autoOrient;
};

// Splits photo indexes into rows, starting a new row at each break index
const rowsOf = (count: number, breaks: number[]) => {
    const starts = [0, ...breaks.filter((index) => index < count)];
    return starts.map((start, i) => {
        const end = starts[i + 1] ?? count;
        return Array.from({ length: end - start }, (_, offset) => start + offset);
    });
};

// Fraction of the content width each photo takes, mirroring the .gallery rows in app.scss
const widthFractions = (ratios: number[], breaks: number[]) => {
    const fractions: number[] = [];
    for (const row of rowsOf(ratios.length, breaks)) {
        // Flex only grows a row to full width when its ratios add up to at least 1, so a lone portrait stays narrower
        const rowRatio = Math.max(1, row.reduce((sum, index) => sum + ratios[index], 0));
        const available = 1 - 0.05 * (row.length - 1);
        for (const index of row) {
            fractions[index] = (ratios[index] / rowRatio) * available;
        }
    }
    return fractions;
};

const vw = (fraction: number, bodyWidth: number) => Math.ceil(fraction * bodyWidth) + 'vw';

const photoHtml = (slug: string, name: string, alt: string, { width, height }: Dimensions, sizes: string) => {
    return `<a href="/${slug}/${name}-2000.jpg" style="--ratio: ${(width / height).toFixed(4)}"><picture>`
        + `<source type="image/avif" srcset="${srcset(slug, name, 'avif')}" sizes="${sizes}">`
        + `<img alt="${alt}" src="/${slug}/${name}-800.jpg" srcset="${srcset(slug, name, 'jpg')}" sizes="${sizes}" width="${width}" height="${height}" loading="lazy" decoding="async">`
        + '</picture></a>';
};

// Rebuilds each photo link written in the posts with responsive AVIF/JPEG markup, sized to its place in the gallery
const renderPhotos = async (html: string, photosPath: string) => {
    const photoPattern = /<a href="\/([^/"]+)\/([^/"]+)-2000\.jpg"><img alt="([^"]*)"[^>]*><\/a>/g;

    const dimensions = new Map<string, Dimensions>();
    for (const [, , name] of html.matchAll(photoPattern)) {
        if (!dimensions.has(name)) {
            dimensions.set(name, await photoDimensions(path.join(photosPath, name + '.jpg')));
        }
    }

    const renderGallery = (gallery: string) => {
        const photos = [...gallery.matchAll(photoPattern)];
        const ratios = photos.map(([, , name]) => dimensions.get(name)!.width / dimensions.get(name)!.height);
        const desktop = widthFractions(ratios, ratios.length >= 5 ? [3] : []);
        const mobile = widthFractions(ratios, ratios.length >= 5 ? [2, 4] : [2]);
        let index = 0;
        return gallery.replace(photoPattern, (_, slug: string, name: string, alt: string) => {
            const sizes = `(max-width: 600px) ${vw(mobile[index], 95)}, (max-width: 800px) ${vw(mobile[index], 80)}, ${vw(desktop[index], 70)}`;
            index++;
            return photoHtml(slug, name, alt, dimensions.get(name)!, sizes);
        });
    };

    return html
        .replace(/<div class="gallery">[\s\S]*?<\/div>/g, renderGallery)
        .replace(photoPattern, (_, slug: string, name: string, alt: string) => {
            return photoHtml(slug, name, alt, dimensions.get(name)!, '(max-width: 600px) 95vw, (max-width: 800px) 80vw, 70vw');
        });
};

// Posts start with a <!--moml:meta ... --> block of `Key: value` lines
const parsePost = (postMarkdownPath: string) => {
    const source = fs.readFileSync(postMarkdownPath, 'utf8');
    const block = source.match(/^<!--moml:meta\n([\s\S]*?)\n-->\n/);
    if (!block) {
        throw new Error('No meta block in ' + postMarkdownPath);
    }
    const meta: Record<string, string> = {};
    for (const line of block[1].split('\n')) {
        const separator = line.indexOf(':');
        meta[line.slice(0, separator).trim().toLowerCase()] = line.slice(separator + 1).trim();
    }
    return { meta, markdown: source.slice(block[0].length).trim() };
};

const processPost = async (postPath: string): Promise<Post> => {
    const { meta, markdown: postMarkdown } = parsePost(path.join(postPath, 'post.md'));
    return {
        slug: makeSlug(meta.title),
        title: meta.title,
        date: new Date(meta.date + 'T00:00:00Z'),
        hero: meta.hero,
        heroAlt: meta.heroalt ?? meta.title,
        intro: meta.intro,
        html: await renderPhotos(markdown.render(postMarkdown), path.join(postPath, 'photos')),
    };
};

const processImage = async (imagePath: string, destinationPath: string, filename: string, imageSize: number, format: typeof imageFormats[number]) => {
    const filePath = path.join(destinationPath, `${filename}-${imageSize}.${format}`);
    if (fs.existsSync(filePath) && fs.statSync(filePath).mtimeMs >= fs.statSync(imagePath).mtimeMs) {
        return;
    }
    const image = sharp(imagePath).autoOrient().resize(imageSize, imageSize, {
        fit: sharp.fit.inside,
        withoutEnlargement: true,
    });
    await (format === 'avif' ? image.avif({ effort: 4 }) : image.jpeg()).toFile(filePath);
};

const processImageSizes = (imagePath: string, destinationPath: string) => {
    console.log('Processing image: ' + imagePath);
    const filename = path.parse(imagePath).name;
    return Promise.all(imageSizes.flatMap((imageSize) => {
        return imageFormats.map((format) => processImage(imagePath, destinationPath, filename, imageSize, format));
    }));
};

const generatePages = (posts: Post[], css: string) => {
    fs.writeFileSync('./public/index.html', homeTemplate({
        css,
        title: 'Joel Gone Wild',
        description: siteDescription,
        path: '/',
        image: siteUrl + '/assets/joel-vardy.jpg',
        ogType: 'website',
        twitterCard: 'summary',
        posts,
    }), 'utf8');

    for (const post of posts) {
        fs.writeFileSync('./public/' + post.slug + '/index.html', postTemplate({
            css,
            title: post.title,
            description: post.intro,
            path: '/' + post.slug + '/',
            image: `${siteUrl}/${post.slug}/${post.hero}-1200.jpg`,
            ogType: 'article',
            twitterCard: 'summary_large_image',
            posts,
            post,
        }), 'utf8');
    }

    fs.writeFileSync('./public/feed.xml', feedTemplate({ siteUrl, description: siteDescription, posts }), 'utf8');
    fs.writeFileSync('./public/sitemap.xml', sitemapTemplate({ siteUrl, posts }), 'utf8');
};

const main = async () => {
    makeDirectoryExist('public');

    const postPaths = directoriesIn('posts');
    const selectedPostPath = args.post === undefined ? undefined : path.relative('.', args.post);
    if (selectedPostPath !== undefined && !postPaths.includes(selectedPostPath)) {
        throw new Error('No post found at ' + args.post);
    }

    const posts: Post[] = [];
    for (const postPath of postPaths) {
        const post = await processPost(postPath);
        const publicPostPath = path.join('public', post.slug);
        makeDirectoryExist(publicPostPath);

        if (!args['no-photos'] && (selectedPostPath === undefined || selectedPostPath === postPath)) {
            for (const imagePath of imagesIn(path.join(postPath, 'photos'))) {
                await processImageSizes(imagePath, publicPostPath);
            }
        }

        posts.push(post);
    }

    posts.sort((a, b) => b.date.getTime() - a.date.getTime());

    generatePages(posts, sass.compile('./src/app.scss', { style: 'compressed' }).css);
};

main();
