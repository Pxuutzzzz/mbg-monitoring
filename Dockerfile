FROM php:8.2-cli

# Install sistem dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libonig-dev libxml2-dev libzip-dev \
    libsqlite3-dev sqlite3 nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file aplikasi
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dan build assets (Vite) — abaikan error jika gagal
RUN npm install && npm run build || true

# Buat SQLite database
RUN touch database/database.sqlite

# Copy & set environment
RUN cp .env.example .env

# Override DB ke SQLite
RUN sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env && \
    sed -i '/^#.*DB_HOST/d' .env && \
    sed -i '/^#.*DB_PORT/d' .env && \
    sed -i '/^#.*DB_DATABASE/d' .env && \
    sed -i '/^#.*DB_USERNAME/d' .env && \
    sed -i '/^#.*DB_PASSWORD/d' .env && \
    echo "DB_DATABASE=/var/www/html/database/database.sqlite" >> .env && \
    sed -i 's/APP_ENV=.*/APP_ENV=production/' .env && \
    sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env && \
    sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env

# Generate APP_KEY
RUN php artisan key:generate --force

# Clear any stale cache
RUN php artisan config:clear && php artisan view:clear || true
RUN chmod -R 775 storage bootstrap/cache database

EXPOSE 8080

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
