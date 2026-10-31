FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf \
    && sed -ri "s!<Directory /var/www/>!<Directory ${APACHE_DOCUMENT_ROOT}/>!" /etc/apache2/apache2.conf \
    && sed -i 's/^Listen 80$/Listen 8081/' /etc/apache2/ports.conf \
    && sed -i 's/:80>/:8081>/' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .

EXPOSE 8081

CMD ["apache2-foreground"]
