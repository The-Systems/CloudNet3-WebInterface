FROM php:8.0-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

COPY . /var/www/html/
WORKDIR /var/www/html/

# Building the application
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y git
RUN composer install --no-dev

# Enabling ae2 rewrites
RUN a2enmod rewrite

# Change document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf