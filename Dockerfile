# Use official PHP-FPM image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd zip xml dom fileinfo tokenizer simplexml session ctype

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Copy existing application .env file
COPY .env .env

# Install composer dependencies
RUN composer install --no-interaction --no-scripts

# Install specific npm packages
RUN npm install && \
    npm uninstall flowbite flowbite-vue && \
    npm install flowbite@2.5.1 flowbite-vue@0.1.6

# Create required directories and set permissions
RUN mkdir -p \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    storage/app/public && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Generate application key and create storage link
RUN php artisan storage:link

# Build assets
RUN npm run build

# Expose ports
EXPOSE 8000 5173

# Start both PHP server and Vite
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]