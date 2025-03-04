# Use PHP 8.2 instead of PHP 8.1
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Update packages and install required dependencies
RUN apt-get clean && apt-get update --fix-missing && apt-get install -y \
    iputils-ping \
    default-mysql-client\
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

# Copy application files
COPY . /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data /var/www

# Run Laravel queue worker
CMD ["php", "artisan", "queue:work"]
