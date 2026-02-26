#!/bin/bash

# Get the directory of the script (assumed to be the Laravel project root)
APP_DIR=$(dirname "$(realpath "$0")")

# Change ownership to the web server user (adjust 'www-data' as needed for your server)
echo "Changing ownership of $APP_DIR to web server user..."
sudo chown -R www-data:www-data "$APP_DIR"

# Set permissions for directories
echo "Setting permissions for directories..."
find "$APP_DIR" -type d -exec chmod 755 {} \;

# Set permissions for files
echo "Setting permissions for files..."
find "$APP_DIR" -type f -exec chmod 644 {} \;

# Set writable permissions for storage and cache directories
echo "Setting writable permissions for storage and bootstrap/cache..."
chmod -R 775 "$APP_DIR/storage"
chmod -R 775 "$APP_DIR/bootstrap/cache"

echo "Laravel application permissions have been set successfully!"

