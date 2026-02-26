#!/bin/bash

echo "Waiting for MySQL to be ready..."

until mysql --ssl=0 -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; do
  >&2 echo "MySQL is unavailable - sleeping 3s"
  sleep 3
done

echo "MySQL is up"

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

# Run safe migrations (NO fresh)
php artisan migrate --force || {
  echo "Migration failed"
  exit 1
}

# Optional: seed only if local
if [ "$APP_ENV" = "local" ]; then
  php artisan db:seed --force || true
fi

# Clear and cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Storage link
php artisan storage:link || true

# Fix permissions
mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Starting Apache..."
exec apache2-foreground