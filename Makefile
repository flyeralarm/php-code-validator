PHP_IMAGE_TAG=flyeralarm/php-code-validator:$(PHP_VERSION)
PHP_VERSION?=8.3

PHP_BIN=$(RUNNER) php
COMPOSER_BIN=$(RUNNER) /usr/bin/composer

RUNNER=docker run --init -it --rm -v "$(PWD):/app" -w /app $(PHP_IMAGE_TAG)


# ---------------------------------------------

# make
.DEFAULT_GOAL := install

.PHONY: build
build:
	docker image build --tag $(PHP_IMAGE_TAG) --build-arg PHP_VERSION=$(PHP_VERSION) .
	$(RUNNER) sh -c "php --version && which composer && composer --version"

.PHONY: install
install:
	$(COMPOSER_BIN) install

.PHONY: update
update:
	rm -rf vendor/ composer.lock
	$(COMPOSER_BIN) update

.PHONY: sniff
sniff:
	$(PHP_BIN) vendor/bin/phpcs -w -p -s --standard=ruleset.xml --ignore="tests/*not-allowed*" custom-standards/ tests/

.PHONY: sniff-fix
sniff-fix:
	$(PHP_BIN) vendor/bin/phpcbf -w -p -s --standard=ruleset.xml --ignore="tests/*not-allowed*" custom-standards/ tests/

.PHONY: test
test:
	$(PHP_BIN) tests/runner.php

.PHONY: test-all
test-all:
	PHP_VERSION=8.4 $(MAKE) build update sniff test
	PHP_VERSION=8.3 $(MAKE) build update sniff test
	PHP_VERSION=8.2 $(MAKE) build update sniff test
	PHP_VERSION=8.1 $(MAKE) build update sniff test
	PHP_VERSION=7.4 $(MAKE) build update sniff test
	PHP_VERSION=7.3 $(MAKE) build update sniff test
