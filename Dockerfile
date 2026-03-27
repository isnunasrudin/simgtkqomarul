FROM serversideup/php:8.3-fpm-nginx-alpine
WORKDIR /var/www/html
USER root

RUN apk add --no-cache \
    git \
    curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN install-php-extensions gd intl