# Flyeralarm PHP Coding Guideline Validator


This repository contains the ruleset for the PHP code we develop at [FLYERALARM](https://flyeralarm.com). 
It mostly consists of PSR-2 with some custom additions. The rules are enforced with the help of squizlabs/PHP_CodeSniffer


## Custom Rules in addition to PSR-2

* Variable names must be in lowerCamelCase
* Yoda conditions are forbidden
* Unit tests with @expectedException must contain @expectedExceptionMessage annotation
* Return type annotations (@return) must only contain one of scalar type or object (e.g. no "@return string|null")
* Exceptions messages must not contain exclamation marks or full stops
* Keywords GOTO and EVAL are forbidden
* Underscores in namespaces are forbidden
* Classtype suffixes like Interface, Abstract or Trait are forbidden (e.g. LoggerInterface)


## How-To work within *this* project
To prepare run command:
```
make
```

To test ruleset run command:
```
make test
```


## Embed into *your* project

Add as composer dev dependency:
```
composer config repositories.flyeralarm/php-code-validator git https://github.com/flyeralarm/php-code-validator.git
composer require --dev flyeralarm/php-code-validator
```

Embed code sniffer in your Makefile. To intend please use tabs instead of spaces. \
_Usage:_ vendor/bin/php-code-validator <folder-to-test-one> <folder-to-test-two> <...>

Example Makefile:
```
test:
	vendor/bin/php-code-validator src/ tests/
```


### Update to latest stable

```
composer update flyeralarm/php-code-validator
```


### Run sniffer
```
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
