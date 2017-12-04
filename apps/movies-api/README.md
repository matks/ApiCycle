ApiCycle - Movies Api
=====================

# Install

Use makefile

```
$ make build
```

Configure `app/config/parameters.yml` to enable access to your database

Then create schema and load fixtures:

```
$ make load_fixtures
```

Check your install is correct by running the following command:
```
$ php bin/console server:run
```

This will start a php webserver, you should now be able to browse http://127.0.0.1:8000/ .

# Run tests

## Functional tests

Run Symfony functional tests using phpunit binary:

```
$  vendor/bin/phpunit
```

# Swagger

```
$ make build_swagger
```