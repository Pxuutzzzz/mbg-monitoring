#!/bin/bash
set -e

echo "🚀 Starting MBG Monitoring System..."

# Pastikan SQLite file ada dan writable
touch /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite

# Pastikan storage writable
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan migrasi
echo "📦 Running migrations..."
php artisan migrate --force

# Jalankan seeder
echo "🌱 Seeding database..."
php artisan db:seed --force

echo "✅ Ready! Starting PHP server on port $PORT..."

# Start PHP built-in server (tanpa Apache, tanpa konflik MPM)
exec php -S 0.0.0.0:$PORT -t /var/www/html/public
