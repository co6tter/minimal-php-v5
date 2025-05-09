FROM php:8.4.6-fpm-alpine

RUN apk add --no-cache \
  tzdata \
  oniguruma-dev \
  && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
  && echo "Asia/Tokyo" > /etc/timezone \
  \
  && docker-php-ext-install -j"$(nproc)" mbstring pdo_mysql \
  \
  && apk del oniguruma-dev

RUN wget -qO /usr/local/bin/composer \
  https://getcomposer.org/download/2.8.8/composer.phar \
  && chmod +x /usr/local/bin/composer

COPY php.ini /usr/local/etc/php/conf.d/app.ini

WORKDIR /var/www/html
