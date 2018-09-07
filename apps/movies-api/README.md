ApiCycle - Movies Api
=====================

Symfony API to handle movies CRUD

# Install

Create an empty database in your mysql instance.

Then use the makefile:

```
$ make build
```

Composer will ask you to provide the values to be inserted into `app/config/parameters.yml` to enable access to your mysql database.

Then create schema and load fixtures:

```
$ make load_fixtures
```

Check your install is correct by running the following command:
```
$ php bin/console server:run
```

This will start a php webserver, you should now be able to browse the API. For example open URL `http://127.0.0.1:8000/v1/movies`, this should return 3 of the fixture movies.

# Run tests

## Controller tests

Run Symfony Controller tests using phpunit binary:

```
$  make tests_phpunit
```

# Swagger

Export Swagger v2 definition using swagger-php binary:

```
$ make build_swagger
```

The JSON output is put into `apps/movies-api-client/swagger/swagger.json`.