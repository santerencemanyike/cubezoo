# Use official PHP image with Apache
FROM php:8.1-apache

RUN a2enmod rewrite

# Install PHP dependencies + Node.js/npm (needed for Telescope frontend)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zip unzip git curl default-mysql-client \
    nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip \
    && apt-get clean

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

ARG APP_ENV=production
ENV APP_ENV=${APP_ENV}

# Install PHP & JS dependencies
RUN if [ "$APP_ENV" = "local" ]; then \
        composer install --optimize-autoloader --no-interaction; \
        php artisan telescope:install || true; \
        npm install && npm run dev; \
    else \
        composer install --no-dev --optimize-autoloader --no-interaction; \
    fi

# Set permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Configure Apache to serve from public/
COPY apache/laravel.conf /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]