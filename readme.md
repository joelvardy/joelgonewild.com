# Joel Gone Wild

This is a blog initially built to document my 2014 Icelandic trip however I have since used it to document several trips I've been on both since and also previous trips.

## Installing

```
yarn install
```

## Development

```
yarn run dev
./process.js
php -S 127.0.0.1:1337 -t public
```

## Testing CircleCI

Install the [CirlceCI CLI](https://circleci.com/docs/2.0/local-jobs/) locally.

### Validate Config

```
circleci config validate -c ./.circleci/config.yml
```

### Running a Build

```
rm -r ./node_modules
circleci build -e AWS_ACCESS_KEY_ID=CHANGEME -e AWS_SECRET_ACCESS_KEY=CHANGEME
```

Built by [Joel Vardy][joelvardy].

  [joelvardy]: https://joelvardy.com/
