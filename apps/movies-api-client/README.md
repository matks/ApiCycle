ApiCycle - Movies Api Client
============================

Silex tool to manipulate Movies API using a generated API client

# Install

Use makefile

```
$ make build
```

Create the file `app/parameters.yml` to enable access to your API.

To do so, copy the dist file `app/parameters.yml.dist` and fill it with the URL of your *running* Movies API. If it is running on `http://127.0.0.1:8000/` then you should be able to leave the file untouched.

```
$ cp app/parameters.yml.dist app/parameters.yml
```

# Run tests

## Functional tests

**The Movies API must be running** while the behat tests suite is performed.

You can do it using Symfony built-in server (`php bin/console server:run`) for example.

To run the behat test suite, use the Makefile:

```
$ make tests_behat
```

# Api Client

Generate API Client using jane-openapi binary:

```
$ make generate_api_client
```

The classes are built in `generated` folder.