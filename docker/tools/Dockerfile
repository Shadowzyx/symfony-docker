FROM php:7.0-cli

ARG SYMFONY_ENV=dev

RUN apt-get update && apt-get install -y \
    apt-transport-https \
    libicu-dev \
    git \
    zlib1g-dev \
    libxml2-dev \
    mysql-client

RUN docker-php-ext-install -j$(nproc) intl mbstring zip mysqli pdo pdo_mysql soap

# Xdebug
RUN pecl install -o -f xdebug-2.4.0 \
    && rm -rf /tmp/pear

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

# Nodejs
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs

# Capistrano 3
RUN set -ex \
    && if [ "$SYMFONY_ENV" = "dev" ]; then \
        apt-get install -y rubygems ruby-dev; \
        gem install -N bundler --no-document; \
        bundle config --global silence_root_warning 1; \
    fi

# Assign a shell to user www-data
RUN chsh -s /bin/bash www-data

# Access right
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www/html

# copy Configuration files
ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
COPY .bashrc /var/www/.bashrc

WORKDIR /var/www/html
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
