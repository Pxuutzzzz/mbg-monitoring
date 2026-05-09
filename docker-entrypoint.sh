#!/bin/bash
set -e

echo "🚀 Starting MBG Monitoring System..."

# Pastikan SQLite file ada
touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

# Jalankan migrasi
echo "📦 Running migrations..."
php artisan migrate --force

# Jalankan seeder
echo "🌱 Seeding database..."
php artisan db:seed --force

echo "✅ Ready! Starting Apache..."

# Start Apache
apache2-foreground
