# Use Node.js + PHP image
FROM node:20-alpine

# Install PHP and composer
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
    composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-scripts --no-autoloader

# Copy package.json and package-lock.json
COPY package*.json ./

# Install npm packages with specific versions
RUN npm install && \
    npm uninstall flowbite flowbite-vue && \
    npm install flowbite@2.5.1 flowbite-vue@0.1.6

# Copy the rest of the application
COPY . .

# Create storage directories
RUN mkdir -p storage/framework/views && \
    mkdir -p storage/framework/cache && \
    mkdir -p storage/framework/sessions

# Set up environment
RUN cp .env.example .env && \
    php artisan key:generate && \
    php artisan storage:link

# Generate composer autoloader
RUN composer dump-autoload

# Build assets
RUN npm run build

# Expose ports
EXPOSE 8000 5173

# Start script
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]