FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# 👇 important (backend folder set)
ENV APACHE_DOCUMENT_ROOT /var/www/html/backend

COPY . /var/www/html/

# 👇 document root replace
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite