
# PHP DEPENDENCIES
FROM php:7.2-apache AS phpdependencies
WORKDIR /var/www/html/
RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get -y install git curl zip
# Install Composer
ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --version="1.6.2" --install-dir="/usr/local/bin" --filename="composer"
COPY composer.json .
RUN composer install --no-scripts --no-autoloader

# Copy everything across
COPY . .
# Handle FCL
RUN composer update --prefer-source --no-autoloader --no-scripts \
&& composer dump-autoload --optimize

# MAIN BUILD
FROM ubuntu:16.04

# Get apt dependencies
RUN apt-get update &&  apt-get install -y \
 curl git software-properties-common openssh-client python-software-properties

RUN  LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php

RUN apt-get update && apt-get upgrade -y
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install \
    git apache2 curl ca-certificates supervisor nodejs npm lynx-cur php7.2 php7.2-mysql libapache2-mod-php7.2 php7.2-xml php7.2-curl php7.2-gd php7.2-mbstring php7.2-zip

# Enable apache mods.
RUN a2enmod php7.2 && a2enmod rewrite

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.2/apache2/php.ini && sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.2/apache2/php.ini

ARG APP_ENV
ENV APP_ENV=$APP_ENV

# Manually set up the apache environment variables
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_PID_FILE=/var/run/apache2/apache2.pid
ENV APACHE_RUN_DIR=/var/run/apache2
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_LOG_DIR=/var/log/apache2
ENV APACHE_LOG_LEVEL=warn
ENV APACHE_CUSTOM_LOG_FILE=/proc/self/fd/1
ENV APACHE_ERROR_LOG_FILE=/proc/self/fd/2

WORKDIR /var/www/html/
COPY --chown=www-data . .
COPY --from=phpdependencies --chown=www-data /var/www/html/vendor vendor
COPY public/.htaccess ./public/.htaccess
COPY .env.example .env
RUN php artisan key:generate \

# Prevent ExpiresActive errors
&& ln -s /etc/apache2/mods-available/expires.load /etc/apache2/mods-enabled/

COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf
COPY apache2-foreground /usr/local/bin/
COPY migrate-db.sh migrate-db.sh
EXPOSE 80
ENTRYPOINT ["./migrate-db.sh"]
CMD ["apache2-foreground"]
