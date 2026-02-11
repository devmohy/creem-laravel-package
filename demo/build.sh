#!/usr/bin/env bash
# Render.com build script for Laravel

set -e

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Creating SQLite database..."
touch database/database.sqlite

echo "Running migrations..."
php artisan migrate --force

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setting permissions..."
chmod -R 755 storage bootstrap/cache

echo "Build complete!"
