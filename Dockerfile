FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev zip \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip xml dom \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

# Install Laravel (bootstrap)
RUN composer create-project laravel/laravel . --prefer-dist

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/vendor

EXPOSE 9000
CMD ["php-fpm"]
