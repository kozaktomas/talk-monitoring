FROM php:7.2-apache

ADD docker/virtual_host.conf /etc/apache2/sites-available/000-default.conf

ADD https://github.com/DataDog/dd-trace-php/releases/download/0.32.1/datadog-php-tracer_0.32.1_amd64.deb datadog-php-tracer.deb

RUN apt-get update && apt-get install -y zlib1g-dev git libpq-dev libzip-dev unzip \
    && docker-php-ext-install sockets zip \
    && a2enmod rewrite \
    && dpkg -i datadog-php-tracer.deb \
    && apt-get install -f \
    && pecl install -o -f redis-3.1.6 \
    && docker-php-ext-enable redis \
    && rm -rf /tmp/pear \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
