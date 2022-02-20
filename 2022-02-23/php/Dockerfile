FROM php:8.1-fpm-alpine

MAINTAINER kozak@talko.cz

RUN apk add --no-cache \
    bash \
    nano \
    vim \
    mc \
    zlib \
    libpq \
    postgresql-dev \
    zlib-dev \
    libzip-dev \
    unzip \
    freetype-dev \
    libjpeg-turbo-dev \
    libmcrypt \
    libpng-dev \
    icu-dev \
    openssl \
    git \
    fcgi

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS && pecl install -o -f redis && docker-php-ext-enable redis
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"


ADD https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck /usr/local/bin/php-fpm-healthcheck
RUN chmod +x /usr/local/bin/php-fpm-healthcheck

WORKDIR /code
