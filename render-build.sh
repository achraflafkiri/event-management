#!/usr/bin/env bash
# Exit on error
set -o errexit

# Build commands
composer install --no-dev --optimize-autoloader
npm ci --only=production
npm run build

# Laravel setup
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --force