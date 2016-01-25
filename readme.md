# Travel Blog

This is a blog initially built to be ready for my 2014 Icelandic trip, however, if it works well, I plan to use it again in future trips.

## Development

I'm using per-project Homestead configuration, to develop locally you should use the commands below:

```
composer install
npm install
vagrant up
echo 192.168.10.13 joelgonewild.dev | sudo tee -a /etc/hosts
gulp watch
```

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
