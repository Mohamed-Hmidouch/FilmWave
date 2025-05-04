FROM php:8.2-fpm
WORKDIR /var/www

# Combinez toutes les installations en une seule commande
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* 

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extensions
RUN docker-php-ext-install \
    gettext \
    intl \
    pdo_mysql \
    bcmath \
    ctype \
    fileinfo \
    mbstring \
    opcache \
    xml \
    zip \
    exif \
    pcntl

# Configuration PHP
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini

