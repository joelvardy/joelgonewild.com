# Joel Gone Wild

This is a blog initially built to document my 2014 Icelandic trip however I have since used it to document several trips I've been on both since and also previous trips.

```
npm install
npm run production
node ./process.js
aws s3 sync public/. s3://joelgonewild.com --acl=public-read --delete --exclude ".DS_Store" --size-only
```

Built by [Joel Vardy][joelvardy].

  [joelvardy]: https://joelvardy.com/
