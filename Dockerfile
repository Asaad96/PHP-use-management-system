FROM php:8.2-apache


RUN docker-php-ext-install mysqli pdo pdo_mysql


COPY . /var/www/html/

WORKDIR /var/www/html/PHP_PROJECT/Project_root

RUN docker-php-ext-install pdo pdo_mysql


EXPOSE 80

CMD ["apache2-foreground"]