# Flyeralarm Coding Guidelines


This repository contains the ruleset for the PHP code we develop at flyeralarm. 
It mostly consists of PSR-2 with some custom additions. The rules are enforced with the help of squizlabs/PHP_CodeSniffer


How-To work within *this* project
------
To prepare run command:
```
make
```

To test ruleset run command:
```
make test
```


Embed into *your* project
------------------------

Add as composer dev dependency:
```
composer config repositories.flyeralarm/coding-guidelines git ssh://git@stash.flyeralarm:7999/cfa/coding-guidelines.git
composer require --dev flyeralarm/coding-guidelines
```

Embed code sniffer in your Makefile. To intend please use tabs instead of spaces. \
_Usage:_ vendor/bin/fa-coding-guideline-validator <folder-to-test-one> <folder-to-test-two> <...>
```
test:
	vendor/bin/fa-coding-guideline-validator src/ tests/
```


Update to latest stable
-----------------------

```
composer update flyeralarm/coding-guidelines
```


Run sniffer within your project
-------------------------------
```
make test
```


Use within PHPStorm
-------------------
1) Ensure the path to PHP Code Sniffer is configured - [open configuration manual](https://confluence.jetbrains.com/display/PhpStorm/PHP+Code+Sniffer+in+PhpStorm#PHPCodeSnifferinPhpStorm-1.1.SpecifyingthepathtoPHPCodeSniffer) 
2) Open settings: \
   Mac: `PhpStorm` > `Preferences` > `Editor` > `Inspections` > `PHP` \
   Windows & Linux: `File` > `Settings` > `Editor` > `Inspections` > `PHP` \
3) Activate/Tick checkbox for `PHP Code Sniffer validation`
4) Click on the item `PHP Code Sniffer validation` to open its settings on the right hand side
5) Choose "Custom" for „Coding standard:“ and click on `...` on the right hand side
6) Select Path to ruleset. This would be something like <YOUR_APP_ROOT>/vendor/flyeralarm/coding-guidelines/ruleset.xml
7) Confirm dialogs by pressing `ok`
