ARG PHP_VERSION=8.2
FROM php:$PHP_VERSION-cli-alpine

RUN apk add git

COPY --from=composer /usr/bin/composer /usr/bin/composer

