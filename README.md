# Flyeralarm Coding Guidelines


This repository contains the ruleset for the PHP code we develop at flyeralarm. 
It mostly consists of PSR-2 with some custom additions. The rules are enforced with the help of squizlabs/PHP_CodeSniffer


How-To
-----------------
To prepare run command:
```
make
```

To test ruleset run command:
```
make test
```

Embed into your project
------------------------

Add as composer dev dependency:
```
composer config repositories.flyeralarm/coding-guidelines git ssh://git@stash.flyeralarm:7999/cfa/coding-guidelines.git
composer require --dev flyeralarm/coding-guidelines
```

Use this command to install:
```
composer update flyeralarm/coding-guidelines
```

Embed code sniffer in your Makefile. To intend please use tabs instead of spaces. 
```
test:
	vendor/bin/fa-coding-guideline-validator src/ tests/
```

Run sniffer within your project
-------------------------------
```
make test
```

Use within PHPStorm
-------------------
- Open settings:
`File` > `Default Settings...` > `Editor` > `Inspections` > `PHP`
- Activate Option `PHP Code Sniffer validation`
- Choose "Custom" for „Coding standard:“ and click on `...` on the right hand side
- Select Path to ruleset. This would be something like <YOUR_APP_ROOT>/vendor/flyeralarm/coding-guidelines/ruleset.xml
- Confirm dialogs by pressing `ok`
