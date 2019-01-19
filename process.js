#!/usr/bin/env node

'use strict';

const fs = require('fs');
const path = require('path');
const slugify = require('slugify');
const markdownData = require('markdown-data');
const markdown = require('markdown-it')({
    html: true,
});
const sharp = require('sharp');
const handlebars = require('handlebars');
const handlebarsMoment = require('handlebars.moment');
const handlebarsLayouts = require('handlebars-layouts');

const imageSizes = [400, 800, 1200, 1600, 2000];

handlebarsMoment.registerHelpers(handlebars);
handlebars.registerHelper(handlebarsLayouts(handlebars));

handlebars.registerPartial('layout', fs.readFileSync('./templates/layout.hbs', 'utf8'));

const homeTemplate = handlebars.compile(fs.readFileSync('./templates/home.hbs', 'utf8'));
const postTemplate = handlebars.compile(fs.readFileSync('./templates/post.hbs', 'utf8'));

const makeDirectoryExist = (path) => {
    if (!fs.existsSync(path)) {
        fs.mkdirSync(path);
    }
};

const makeSlug = (string) => {
    return slugify(string, {
        lower: true,
    });
};

const directoryContents = (rootPath, filter) => {
    let results = [];
    const directories = fs.readdirSync(rootPath);
    directories.forEach((directory) => {
        const directoryPath = path.join(rootPath, directory);
        if (typeof filter === 'function') {
            if (!filter(directoryPath)) {
                return;
            }
        }
        results.push(directoryPath);
    });
    return results;
};

const directoriesIn = (rootPath) => {
    return directoryContents(rootPath, (itemPath) => {
        return fs.lstatSync(itemPath).isDirectory();
    });
};

const imagesIn = (rootPath) => {
    return directoryContents(rootPath, (itemPath) => {
        return path.parse(itemPath).ext === '.jpg';
    });
};

const processPost = (postMarkdownPath) => {
    let postFile = fs.readFileSync(postMarkdownPath);
    let post = markdownData.parse(postFile.toString());
    return {
        slug: makeSlug(post.data.meta.title),
        title: post.data.meta.title,
        date: post.data.meta.date,
        hero: post.data.meta.hero,
        intro: post.data.meta.intro,
        html: markdown.render(post.markdown),
    };
};

const processImage = async (imagePath, destinationPath, filename, imageSize) => {
    let filePath = path.join(destinationPath, filename + '-' + imageSize + '.jpg');
    await sharp(imagePath).resize(imageSize, imageSize).max().toFile(filePath);
};

const processImageSizes = (imagePath, destinationPath) => {
    console.log('Processing image: ' + imagePath);
    const filename = path.parse(imagePath).name;
    let images = imageSizes.slice(0);
    return Promise.all(images.map((imageSize) => {
        return processImage(imagePath, destinationPath, filename, imageSize);
    }));
};

const generatePages = (posts) => {
    fs.writeFileSync('./public/index.html', homeTemplate({
        title: 'Joel Gone Wild',
        description: 'I really enjoy exploring new places, so in 2014 I started writing down the things I had done both for others to read, and so future me can read too!',
        path: '/',
        posts,
    }), 'utf8');

    for (let post of posts) {

        fs.writeFileSync('./public/' + post.slug + '/index.html', postTemplate({
            title: post.title,
            description: post.intro,
            path: '/' + post.slug + '/',
            posts,
            post,
        }), 'utf8');

    }
};

return (async () => {

    makeDirectoryExist('public');
    let posts = [];

    let postPaths = [];
    if (typeof process.argv[2] !== 'undefined') {
        postPaths.push(process.argv[2]);
    } else {
        postPaths = directoriesIn('posts');
    }

    for (let postPath of postPaths) {

        const post = processPost(path.join(postPath, 'post.md'));
        const publicPostPath = path.join('public', post.slug);
        makeDirectoryExist(publicPostPath);

        if (process.argv[2] !== '--no-photos') {
            const imagePaths = imagesIn(path.join(postPath, 'photos'));
            for (let imagePath of imagePaths) {
                await processImageSizes(imagePath, publicPostPath);
            }
        }

        posts.push(post);

    }

    posts.sort((a, b) => {
        return new Date(b.date) - new Date(a.date);
    });

    generatePages(posts);

})();
