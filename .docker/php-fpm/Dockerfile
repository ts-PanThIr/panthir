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
    tesseract-ocr\
    acl \
    curl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

# Xdebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
   pdo pdo_pgsql zip xsl gd intl opcache exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./.docker/php-fpm/xdebug.ini "${PHP_INI_DIR}/conf.d"
COPY ./.docker/php-fpm/error_reporting.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www
CMD php-fpm
