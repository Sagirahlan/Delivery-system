# Stage 1: Build assets with Node.js & Vite
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Application
FROM php:8.4-cli

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql zip

# Get latest Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy built assets from frontend-builder stage
COPY --from=frontend-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=php+

# Storage link and caching setup during startup
ENV PORT=10000
EXPOSE 10000

# Start Laravel server binding to 0.0.0.0 and PORT
CMD php artisan key:generate --force || true && \
    php artisan migrate --force || true && \
    php artisan db:seed --class=RoleSeeder --force || true && \
    php artisan storage:link || true && \
    php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
