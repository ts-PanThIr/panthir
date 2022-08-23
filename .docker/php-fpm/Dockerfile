FROM php:8.1-fpm-buster

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    libpq-dev \
    acl \
    curl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

# Xdebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

COPY ./.docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
#COPY ./.docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./.docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/error_reporting.ini

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
   pdo pdo_pgsql zip xsl gd intl opcache exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Source code
#RUN chown www-data:www-data /var/www
#COPY --chown=www-data:www-data ./ /var/www
#WORKDIR /var/www
#
#USER www-data

WORKDIR /var/www
CMD php-fpm
#EXPOSE 9000