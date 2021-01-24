FROM php:8.0-apache
RUN docker-php-ext-install mysqli

COPY apache2.conf /etc/apache2/apache2.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN mkdir /etc/apache2/ssl
COPY server.crt /etc/apache2/ssl/server.crt
COPY server.key /etc/apache2/ssl/server.key
COPY php.ini-production /usr/local/etc/php/8.0/php.ini

WORKDIR /var/www
COPY config.php .
RUN touch log.txt
RUN chmod 666 log.txt
RUN mkdir files
RUN chmod 777 files

ADD html /var/www/html

RUN a2enmod ssl
RUN a2ensite default-ssl
RUN service apache2 restart