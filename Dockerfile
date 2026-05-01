# Use official PHP 8.2 image with FPM
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libzip-dev \
    zip \
    mysql-client \
    autoconf \
    g++ \
    make \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    ctype \
    json \
    tokenizer

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Create necessary directories and set permissions
RUN mkdir -p storage/logs bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Copy entrypoint script
COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

# Expose port (handled by nginx in docker-compose)
EXPOSE 9000

# Set entrypoint
ENTRYPOINT ["/docker-entrypoint.sh"]
