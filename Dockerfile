FROM php:8.3-apache AS base

RUN apt-get update && apt-get install -y libpq-dev unzip \
    && docker-php-ext-install pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .


FROM base AS test

RUN composer install --no-interaction \
    && cp .env.example .env \
    && php artisan key:generate \
    && ./vendor/bin/pint --test \
    && php artisan test


FROM base AS production

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache/data \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
