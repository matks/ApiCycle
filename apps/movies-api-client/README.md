ApiCycle - Movies Api Client
============================

Silex tool to manipulate Movies API using a generated API client

# Install

Use makefile

```
$ make build
```

Configure `app/config/parameters.yml` to enable access to your database

# Run tests

## Functional tests

Generate behat test suite:

```
$ make tests_behat
```

# Api Client

Generate API Client using jane-openapi binary:

```
$ make generate_api_client
```

The classes are built in `generated` folder.