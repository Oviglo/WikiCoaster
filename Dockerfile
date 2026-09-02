FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libicu-dev \
    unzip \
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

RUN pecl install apcu \
    && docker-php-ext-enable apcu

# Configuration d'apache pour Symfony
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf \
    && a2enmod rewrite

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer
