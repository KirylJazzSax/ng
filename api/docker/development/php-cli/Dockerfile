FROM php:8.0-cli-alpine

ENV XDEBUG_VERSION 3.0.4

RUN apk add --no-cache postgresql-dev bash coreutils git \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install pdo_pgsql xdebug \
    && apk del git

RUN apk add --no-cache unzip

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./development/php/conf.d /usr/local/etc/php/conf.d

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet

WORKDIR /app
