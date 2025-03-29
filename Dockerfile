# Use PHP 8.2 CLI (not FPM)
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www

# Install required system packages
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
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose the dev server port
EXPOSE 8000

# Start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"] 