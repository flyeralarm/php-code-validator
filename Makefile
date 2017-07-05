PHP_BIN=php
COMPOSER_BIN=$(PHP_BIN) composer.phar

# ---------------------------------------------

# make
.DEFAULT_GOAL := install-dev

# make test
test:
	$(PHP_BIN) tests/runner.php

# make install
install:

# ---------------------------------------------
# functions

install-dev:
	$(COMPOSER_BIN) install
