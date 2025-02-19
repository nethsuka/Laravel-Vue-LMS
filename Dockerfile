# Use PHP 8.2 base image
FROM php:8.2-fpm-alpine

# Install Node.js
RUN apk add --no-cache \
    nodejs \
    npm

# Install PHP extensions and dependencies
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    $PHPIZE_DEPS && \
    docker-php-ext-install \
    pdo_mysql \
    bcmath \
    zip \
    dom \
    xml \
    fileinfo \
    tokenizer \
    simplexml \
    session \
    ctype

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-scripts --no-interaction --prefer-dist

# Copy package.json
COPY package*.json ./

# Install specific npm packages
RUN npm install && \
    npm uninstall flowbite flowbite-vue && \
    npm install flowbite@2.5.1 flowbite-vue@0.1.6

# Copy the rest of the application
COPY . .

# Set permissions
RUN chown -R www-data:www-data /app && \
    chmod -R 775 storage bootstrap/cache

# Create storage directory structure
RUN mkdir -p \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    storage/app/public && \
    chmod -R 775 storage

# Create storage symlink and generate autoload
RUN php artisan storage:link || true && \
    composer dump-autoload

# Build assets
RUN npm run build

# Expose ports
EXPOSE 8000 5173

# Start services
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]