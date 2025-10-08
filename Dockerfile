
FROM php:8.2-apache


COPY . /var/www/html/


WORKDIR /var/www/html/PHP_Project/Project_root


RUN docker-php-ext-install pdo pdo_mysql


RUN echo "DirectoryIndex index.php" > /etc/apache2/conf-enabled/directoryindex.conf


EXPOSE 80


CMD ["apache2-foreground"]
