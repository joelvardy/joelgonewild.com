# Travel Blog

This is a blog initially built to document my 2014 Icelandic trip however I have since used it to document several trips I've been on both since and also previous trips.

## Development

I'm using per-project Homestead configuration, to develop locally you should use the commands below to set up the project initially:

```
composer install
npm install
php vendor/bin/homestead make
# Update details in ./Homestead.yaml
echo 192.168.10.13 joelgonewild.dev | sudo tee -a /etc/hosts
vagrant up
```

To have the assets automatically build based on changes (for development) run: `npm run watch`

To generate the assets before commiting any code: `npm run production`

## Deployment

```
composer install
chmod 777 ./cache
```

## Data

This is all about data, I want to keep a record of activities along with awesome photos. My data structure will look something like this:

```
posts/
    iceland/
        svinafellsjokull-glacier/
            photos/
                trekking-team.jpg
            post.php
        category.json
```

Built by [Joel Vardy][joelvardy].

  [joelvardy]: https://joelvardy.com/
