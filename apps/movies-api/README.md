ApiCycle - Movies Api
=====================

# Install

Install dependencies with composer binary:

```
$ php composer.phar install
```

Configure `app/config/parameters.yml` to enable access to your database

Then create schema and load fixtures:

```
$ php app/console doctrine:schema:create
$ php app/console doctrine:fixtures:load
```

Check your install is correct by running the following command:
```
$ php app/console server:run
```

This will start a php webserver, you should now be able to browse http://127.0.0.1:8000/ .

# Run tests

## Functional tests

Run Symfony functional tests using phpunit binary:

```
$  vendor/bin/phpunit
```