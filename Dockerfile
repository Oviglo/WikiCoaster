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

# NPM
RUN apt-get update \
    && apt-get install -y ca-certificates curl gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_22.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*