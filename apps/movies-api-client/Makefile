PHP ?= php
ENV ?= dev
JANE ?= vendor/bin/jane-openapi
BEHAT ?= vendor/bin/behat

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
	$(MAKE) composer_install

generate_api_client: ## generate API Client classes
	$(JANE) generate swagger/swagger.json 'ApiCycle\Generated\ApiMoviesClient' generated/

tests_behat: ## perform behat functional tests
	$(MAKE) reset_remote_fixtures ENV=$(ENV)
	$(BEHAT)

reset_remote_fixtures: ## reset Movies API fixtures in movies-api project
	$(MAKE) -C ../movies-api reset_fixtures ENV=$(ENV)
