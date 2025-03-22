# Use PHP 8.2 FPM base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get clean && apt-get update --fix-missing && apt-get install -y \
    iputils-ping \
    default-mysql-client \
    unzip \
    curl \
    git \
    libpng-dev \
    pkg-config \
    libonig5 \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure mbstring \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the Laravel project files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Ensure Laravel caches are built
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache || true

# Run the Laravel queue worker
CMD ["php", "artisan", "queue:work", "--tries=3", "--timeout=90"]
