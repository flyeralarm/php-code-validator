Prepare for development
-------
```make```

Use within your project
--------------------------
Install php code sniffer:
composer require --dev flyeralarm/coding-guidelines
```
composer require --dev squizlabs/php_codesniffer:3.0.*
```

Add config as composer dev dependency:
```
composer config repositories.flyeralarm/coding-guidelines git ssh://git@stash.flyeralarm:7999/cfa/coding-guidelines.git
composer require --dev flyeralarm/coding-guidelines
```

Update both to install:
```
composer update squizlabs/php_codesniffer flyeralarm/coding-guidelines
```

Embed php code sniffer in your Makefile. To intend please use tabs instead of spaces. 
```
test:
	php vendor/bin/phpcs --standard=vendor/flyeralarm/coding-guidelines/ruleset.xml src/
```

Run your tests
```
cd $YOUR_PROJECT_ROOT
make test
```
