FROM php:7.4.4-zts-alpine3.11

WORKDIR /home/php/src
COPY ./src /home/php/src
RUN wget https://getcomposer.org/composer-stable.phar -O /usr/bin/composer && chmod +x /usr/bin/composer && composer install --dev

CMD ["/home/php/src/bin/console", "server:run", "0.0.0.0:8000"]