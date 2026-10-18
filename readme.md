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

Photos are only resized when the photo or the image settings in `process.ts` change, tracked by content hash in `.image-manifest.json`.

## Deploying

Pushing to `main` deploys via GitHub Actions, which assumes the `joelgonewild-github-deploy` IAM role over OIDC. It deploys `resources/site.yml` (a no-op when unchanged), then syncs `public/` to S3 and invalidates CloudFront.

The role itself lives in `resources/github-deploy-role.yml` and is deployed by hand, see the command at the top of that file.

Built by [Joel Vardy](https://joelvardy.com/).
