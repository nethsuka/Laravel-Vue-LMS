# Use Node.js + PHP image
FROM node:20-alpine

# Install PHP and all required extensions
RUN apk add --no-cache \
    php82 \
    php82-phar \
    php82-openssl \
    php82-json \
    php82-mbstring \
    php82-tokenizer \
    php82-fileinfo \
    php82-dom \
    php82-xml \
    php82-xmlwriter \
    php82-curl \
    php82-session \
    php82-ctype \
    php82-pdo \
    php82-pdo_mysql \
    php82-bcmath \
    php82-zip \
    php82-sqlite3 \
    php82-simplexml \
    composer

# Set working directory
WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

# Copy the entire application
COPY . .

# Set up permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R nobody:nobody storage bootstrap/cache

# Create necessary directories and set permissions
RUN mkdir -p \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    storage/app/public && \
    chown -R nobody:nobody storage

# Generate composer autoloader
RUN composer dump-autoload

# Install npm packages with specific versions
RUN npm install && \
    npm uninstall flowbite flowbite-vue && \
    npm install flowbite@2.5.1 flowbite-vue@0.1.6

# Create symlink for storage after all permissions are set
RUN php artisan storage:link || true

# Build assets
RUN npm run build

# Expose ports
EXPOSE 8000 5173

# Start script
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]