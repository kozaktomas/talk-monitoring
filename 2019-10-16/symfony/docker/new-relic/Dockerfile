FROM php:7.2-apache

ADD virtual_host.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y zlib1g-dev git libpq-dev libzip-dev unzip gnupg \
    && docker-php-ext-install pdo pdo_pgsql zip sockets \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN \
  curl -L https://download.newrelic.com/php_agent/release/newrelic-php5-9.1.0.246-linux.tar.gz | tar -C /tmp -zx && \
   export NR_INSTALL_USE_CP_NOT_LN=1 && \
    export NR_INSTALL_SILENT=1 && \
     /tmp/newrelic-php5-*/newrelic-install install && \
      rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* && \
        sed -i -e 's/"REPLACE_WITH_REAL_KEY"/"eu01xx3e6c67c4407881222f675460127aae2469"/' \
               -e 's/newrelic.appname = "PHP Application"/newrelic.appname = "Test Symfony app"/' \
               /usr/local/etc/php/conf.d/newrelic.ini