# Joel Gone Wild

This is a blog initially built to document my 2014 Icelandic trip

## Installing

```
npm install
```

## Development

```
npm run dev
```

This rebuilds the site when anything in `src/` or `posts/` changes, and serves `public/` at http://localhost:3000.

To build once:

```
npm run build                                   # every post and photo
npm run build -- --post posts/2026-skye-autumn  # only process photos for one post
npm run build -- --no-photos                    # pages only
```

Photos are only resized when the source is newer than the output. After changing the image settings in `process.ts`, delete `public/<post>/` to regenerate them.

Built by [Joel Vardy](https://joelvardy.com/).
