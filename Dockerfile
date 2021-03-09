FROM php:7.4-fpm-alpine
COPY composer.lock composer.json /var/www/
WORKDIR /var/www
RUN apk --update add \
    alpine-sdk \
    curl \
    && rm -rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 9000
CMD ["php-fpm"]