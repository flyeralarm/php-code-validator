# FLYERALARM PHP Coding Guideline Validator


This repository contains the ruleset for the PHP code we develop at [FLYERALARM](https://flyeralarm.com). 
It mostly consists of PSR-2 with some custom additions. The rules are enforced with the help of squizlabs/PHP_CodeSniffer


## Custom Rules in addition to PSR-2

* Variable names must be in lowerCamelCase
* Yoda conditions are forbidden
* Unit tests with @expectedException must contain @expectedExceptionMessage annotation
* Return type annotations (@return) must only contain one of scalar type, object (e.g. no "@return string|null") or 
an array of one these
* Exceptions messages must not contain exclamation marks or full stops
* Keywords GOTO and EVAL are forbidden
* Underscores in namespaces are forbidden
* Classtype suffixes like Interface, Abstract or Trait are forbidden (e.g. LoggerInterface)


## How-To work within *this* project
To prepare run command:
```bash
make
```

To test ruleset run command:
```bash
make test
```


## Embed into *your* project

Add as composer dev dependency:
```
composer config repositories.flyeralarm/php-code-validator git https://github.com/flyeralarm/php-code-validator.git
composer require --dev flyeralarm/php-code-validator
```

Embed code sniffer in your Makefile. To intend please use tabs instead of spaces.

Example Makefile:
```make
test:
	vendor/bin/phpcs -w -p -s --standard=vendor/flyeralarm/php-code-validator/ruleset.xml src/ tests/
```

### Add project specific rules
The recommended way to define custom rules for the own project is to provide a ```phpcs.xml``` in the root of your
project.
PHP_CodeSniffer will automatically detect this standard if no other standard was defined (See [PHP_CodeSniffer Advanced Usage](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage#using-a-default-configuration-file)).

This ```phpcs.xml``` can then reference the FLYERALARM PHP coding standard.
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<ruleset name="Project Rules">
    <file>./src/</file>
    <file>./tests/</file>
    <arg value="sp"/>

    <rule ref="vendor/flyeralarm/php-code-validator/ruleset.xml"/>
    
    <!-- custom rules -->
    
</ruleset>
```

Once the file ```phpcs.xml``` is created the code can be validated using:
```bash
vendor/bin/phpcs
```

### Update to latest stable

```bash
composer update flyeralarm/php-code-validator
```


### Run sniffer
```bash
make test
```


## Use within PHPStorm
1) Ensure the path to PHP Code Sniffer is configured - [open configuration manual](https://confluence.jetbrains.com/display/PhpStorm/PHP+Code+Sniffer+in+PhpStorm#PHPCodeSnifferinPhpStorm-1.1.SpecifyingthepathtoPHPCodeSniffer) 
2) Open settings: \
   Mac: `PhpStorm` > `Preferences` > `Editor` > `Inspections` > `PHP` \
   Windows & Linux: `File` > `Settings` > `Editor` > `Inspections` > `PHP` \
3) Activate/Tick checkbox for `PHP Code Sniffer validation`
4) Click on the item `PHP Code Sniffer validation` to open its settings on the right hand side
5) Choose "Custom" for „Coding standard:“ and click on `...` on the right hand side
6) Select Path to ruleset. This would be something like <YOUR_APP_ROOT>/vendor/flyeralarm/php-code-validator/ruleset.xml
7) Confirm dialogs by pressing `ok`


On a side note: [We are searching for talented people to join our various teams of developers in multiple locations](https://karriere.flyeralarm.com/jobs)
