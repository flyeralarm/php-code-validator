# Changelog

## 4.2.0 — 2026-02-26

- Updated `squizlabs/php_codesniffer` to version 3.13.5.

## 4.1.1 — 2024-12-05

- Added fix for missing array key in the yoda sniff for the do-while check.

## 4.1.0 — 2024-02-21

- Remove obsolete `bin/php-code-validator` from composer.

## 4.0.0 — 2023-07-20

- Removed binary executable as it added maintenance overhead (dependency to composer internals) without enough benefits.

## 3.2.4 — 2023-07-18

- Fixed shell interpreter for non-bash environments.

## 3.2.3 — 2023-03-24

- Add sniff to make and CI to apply code style check on self.

## 3.2.2 — 2023-03-23

- Remove `ReturnTypeSniff` with tests and from rulesets as it was too restrictive; use phpstan instead.
- Add GitHub workflow for testing in CI.

## 3.2.1 — 2022-08-29

- Fixed issue with path on Composer 2.
- Updated Composer to 2.4.1.

## 3.2.0 — 2020-10-15

- Added support for `implements` when checking for fully qualified class names.
- Added support for PHP 7.4 by updating shipped `composer.phar`.

## 3.1.0 — 2020-10-14

- Improvements to `FullyQualifiedSniff`.

## 3.0.0 — 2020-10-05

- Updated from PSR-2 to PSR-12.

## 2.3.0 — 2020-10-02

- No release notes.

## 2.1.0 — 2017-10-13

- Allow execution of tests on Windows machines.
- Switch preferred way of usage from shell script to using phpcs directly.
- Allow usage of simple data type `resource` as return type.

## 1.0.1 — 2017-09-08

- No release notes.

## 1.0.0 — 2017-09-08

- Initial release.
