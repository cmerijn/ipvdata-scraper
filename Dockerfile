FROM php:8.2-apache

# Install necessary extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli curl \
    && docker-php-ext-enable mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Apache configuration
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the PHP script and composer files into the container
COPY src/ /var/www/html/
COPY src/composer.json /var/www/html/

# Install PHP dependencies
RUN composer install --working-dir=/var/www/html

# Expose the port
EXPOSE 80
