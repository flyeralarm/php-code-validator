PHP_BIN=php
COMPOSER_BIN=$(PHP_BIN) composer.phar

# ---------------------------------------------

# make
.DEFAULT_GOAL := install

install:
	$(COMPOSER_BIN) install

sniff:
	$(PHP_BIN) vendor/bin/phpcs -w -p -s --standard=ruleset.xml --ignore="tests/*not-allowed*" custom-standards/ tests/

sniff-fix:
	$(PHP_BIN) vendor/bin/phpcbf -w -p -s --standard=ruleset.xml --ignore="tests/*not-allowed*" custom-standards/ tests/

test:
	$(PHP_BIN) tests/runner.php
