FROM php:8.0-apache

COPY . usr/webinterface/
WORKDIR usr/webinterface/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev

USER www-data

EXPOSE 80 443
CMD ["apachectl", "-D", "FOREGROUND"]