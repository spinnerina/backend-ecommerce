# Use PHP base image
FROM php:8.1-fpm

# Install required extensions
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html
