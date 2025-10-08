FROM php:8.2-apache


RUN docker-php-ext-install pdo pdo_mysql


COPY . /var/www/html/


RUN mv /var/www/html/Project_root/index.php /var/www/html/index.php


RUN echo "DirectoryIndex index.php" > /etc/apache2/conf-enabled/directoryindex.conf

EXPOSE 80

CMD ["apache2-foreground"]
