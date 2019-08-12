FROM php:7.3-alpine

RUN docker-php-ext-install sysvsem

RUN apk update && apk upgrade && \
    apk add --no-cache bash git openssh

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer


RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug

