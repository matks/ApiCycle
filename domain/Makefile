PHP ?= php
ENV ?= dev
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
	$(MAKE) composer_install

tests_phpunit: ## perform phpunit unit tests
	$(PHPUNIT) tests
