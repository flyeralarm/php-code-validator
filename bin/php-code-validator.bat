@echo off
setlocal DISABLEDELAYEDEXPANSION

SET BIN_DIR=%~dp0

if exist "%BIN_DIR%\phpcs.bat" (
    REM used within project
    SET SCRIPT_DIR=%BIN_DIR%\..\flyeralarm\php-code-validator
    SET COMPOSER_BIN=%BIN_DIR%
) else (
    REM standalone
    SET SCRIPT_DIR=%BIN_DIR%\..
    SET COMPOSER_BIN=%BIN_DIR%\..\vendor\bin
)

%COMPOSER_BIN%/phpcs.bat -w -p -s --standard=%SCRIPT_DIR%\ruleset.xml %*
