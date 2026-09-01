FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install \
    mysqli \
    gd \
    zip \
    pdo \
    pdo_mysql \
    opcache \
    intl

# Apache
RUN a2enmod rewrite

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer
