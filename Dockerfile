
FROM php:8.2-apache


RUN docker-php-ext-install pdo pdo_mysql


COPY PHP_Project/Project_root/ /var/www/html/


RUN echo "DirectoryIndex index.php" > /etc/apache2/conf-enabled/directoryindex.conf


EXPOSE 80


CMD ["apache2-foreground"]
