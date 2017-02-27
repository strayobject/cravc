FROM php:7.1-fpm

MAINTAINER Michal Zdrojewski <code@strayobject.co.uk>

RUN usermod -u 1000 www-data

# temporarily compile new version as debian has an outdated one
RUN curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/58.2/icu4c-58_2-src.tgz && tar -zxf /tmp/icu.tar.gz -C /tmp && cd /tmp/icu/source && ./configure --prefix=/usr/local && make && make install

RUN apt-get update \
 && apt-get install -y unzip git libcurl4-gnutls-dev zlib1g-dev libicu-dev libpng-dev libjpeg-dev libfreetype6-dev g++ \
 && docker-php-ext-configure intl --with-icu-dir=/usr/local \
 && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
 && docker-php-ext-install pdo pdo_mysql sockets zip json intl gd \
 && apt-get autoremove && apt-get autoclean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install xdebug-2.5.0 \
 && docker-php-ext-enable xdebug

COPY opt/php71/conf/conf.d/*.ini /usr/local/etc/php/conf.d/
COPY opt/php71/conf/php.ini /usr/local/etc/php/php.ini
