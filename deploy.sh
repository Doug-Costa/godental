#!/bin/bash

# Exit on error
set -e

echo "🚀 Starting deployment..."

# Pull latest changes
git pull origin main

# Build and restart containers
echo "📦 Building and starting containers..."
docker compose up -d --build

# Install/Update composer dependencies inside container
echo "composer Install/Update composer dependencies..."
docker compose exec -T app composer install --no-interaction --no-dev --optimize-autoloader

# Run database migrations
echo "🗄️ Running migrations..."
docker compose exec -T app php artisan migrate --force

# Clear and cache configuration/routes
echo "🧹 Clearing and caching..."
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

# Set permissions
echo "🔑 Setting permissions..."
docker compose exec -T app chown -R www-data:www-data storage bootstrap/cache

echo "✅ Deployment finished successfully!"
