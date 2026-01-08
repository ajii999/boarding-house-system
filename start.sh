#!/bin/bash
set -e

# Railway startup script
# This runs migrations and seeders automatically on deployment

echo "=== Railway Startup Script ==="

echo "Setting up storage..."
mkdir -p storage/app/public/receipts
mkdir -p storage/app/public/payment-receipts
mkdir -p storage/app/public/maintenance_photos
# Create symlink - remove existing first to avoid errors
rm -f public/storage
php artisan storage:link
echo "Storage symlink created. Verifying..."
ls -la public/ | grep storage || echo "WARNING: Storage symlink may not have been created"

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

echo "Starting application..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
