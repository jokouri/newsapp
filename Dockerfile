FROM php:8.2-apache

RUN docker-php-ext-install mysqli

RUN mkdir -p /var/www/html/uploads && chown -R www-data:www-data /var/www/html

COPY index.php /var/www/html/index.php
COPY add.php /var/www/html/add.php
