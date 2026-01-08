#!/bin/bash
set -e

# Railway startup script
# This runs migrations and seeders automatically on deployment

echo "=== Railway Startup Script ==="
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

echo "Starting application..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
