FROM php:7.4.4-zts-alpine3.11

WORKDIR /home/php/src
COPY ./src /home/php/src

RUN wget https://getcomposer.org/composer-stable.phar -O /usr/bin/composer && chmod +x /usr/bin/composer && composer install --dev
RUN apk --no-cache add \
        postgresql-dev \
    && docker-php-ext-install \
            pdo \
            pdo_pgsql \
            pgsql

COPY ./docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh


ENTRYPOINT ["/bin/sh"]
CMD ["/entrypoint.sh"]