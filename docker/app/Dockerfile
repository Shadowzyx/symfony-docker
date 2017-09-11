FROM php:7.0-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    zlib1g-dev \
    git \
    libxml2-dev

RUN docker-php-ext-install -j$(nproc) mbstring intl zip mysqli pdo pdo_mysql soap

# Xdebug
RUN pecl install -o -f xdebug-2.4.0 \
    && rm -rf /tmp/pear

ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
