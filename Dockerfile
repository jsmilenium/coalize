FROM php:8.1-fpm-alpine

RUN apk update && apk upgrade &&  apk add $PHPIZE_DEPS && apk add oniguruma-dev && apk add zlib-dev libpng-dev unzip libzip-dev
RUN set -ex\
    && apk --no-cache add \
    && docker-php-ext-install sockets mysqli pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-enable gd zip \
    && pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

