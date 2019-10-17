FROM php:7.2-apache

ADD docker/virtual_host.conf /etc/apache2/sites-available/000-default.conf
ADD https://github.com/DataDog/dd-trace-php/releases/download/0.30.2/datadog-php-tracer_0.30.2_amd64.deb datadog-php-tracer_0.30.2_amd64.deb

RUN apt-get update && apt-get install -y zlib1g-dev git libpq-dev libzip-dev unzip \
    && docker-php-ext-install pdo pdo_pgsql zip sockets \
    && a2enmod rewrite \
    && dpkg -i datadog-php-tracer_0.30.2_amd64.deb \
    && apt-get install -f \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
