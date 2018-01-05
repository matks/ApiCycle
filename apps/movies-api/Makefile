PHP ?= php
ENV ?= dev
SFY_ANSI ?= --ansi
APP_CONSOLE = $(PHP) bin/console $(SFY_ANSI)
SWAGGER = vendor/bin/swagger
PHPUNIT = vendor/bin/phpunit

.DEFAULT_GOAL := help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

composer_install: ## install composer phar
	test -f "composer.phar" || curl -s https://getcomposer.org/installer | $(PHP);
	$(PHP) composer.phar self-update
ifeq ($(ENV),prod)
	$(PHP) composer.phar install --no-dev --optimize-autoloader
else
	$(PHP) composer.phar install
endif

build: ## builds the application
	@echo $(ENV)
ifeq ($(ENV),test)
	cp app/config/parameters.yml.dist app/config/parameters.yml
endif
	$(MAKE) composer_install
	$(APP_CONSOLE) cache:clear --env=$(ENV)

load_fixtures: ## load fixtures
	$(APP_CONSOLE) doctrine:schema:create
	$(APP_CONSOLE) doctrine:fixtures:load --no-interaction

reset_fixtures: ## load fixtures after cleaning the database
	$(APP_CONSOLE) doctrine:schema:drop --force --no-interaction
	$(MAKE) load_fixtures

build_swagger: ## build swagger files
	$(SWAGGER) --exclude vendor --output ../movies-api-client/swagger/swagger.json

tests_phpunit: ## perform phpunit unit tests
	$(PHPUNIT)
