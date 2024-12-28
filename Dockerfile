# Use official PHP image with Apache
FROM php:8.0-apache

# Install required system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libcurl4-openssl-dev \
    libssl-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && composer self-update --stable

# Install MongoDB PHP extension
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy your PHP application into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Install PHP dependencies via Composer
RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Expose port 80
EXPOSE 80

# Set environment variables
ENV COMPOSER_HOME=app/composer
ENV COMPOSER_CACHE_DIR=app/composer/cache
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data

# Set working directory to app
WORKDIR /var/www/html/

# Set default command to run when starting the container
CMD ["apache2-foreground"]