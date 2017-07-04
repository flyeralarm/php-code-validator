COMPOSER_BIN=php composer.phar

# ---------------------------------------------

# make
.DEFAULT_GOAL := install-dev

# make test
test:
	php vendor/bin/phpcs --standard=ruleset.xml --colors -v ValidClass.php

# make install
install:

# ---------------------------------------------
# functions

install-dev:
	$(COMPOSER_BIN) install
