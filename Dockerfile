# Etapa de construcción
FROM composer:2 as builder

WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

# Etapa de producción
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Instalar dependencias
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Configuraciones
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY --from=builder /app /var/www/html

# SOLUCIÓN DEFINITIVA PARA PERMISOS
RUN mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
    && mkdir -p /var/www/html/storage/logs \
    && touch /var/www/html/storage/logs/laravel.log \
    && touch /var/www/html/storage/framework/views/.gitkeep \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configuración de usuario crítica (NUEVO)
RUN apk add --no-cache shadow \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && chgrp -R www-data /var/www/html \
    && chmod -R ug+rwx /var/www/html/storage

# Variables de entorno PARA PRODUCCIÓN
ENV APP_ENV=production \
    APP_DEBUG=false \
    CACHE_DRIVER=file \
    SESSION_DRIVER=file \
    VIEW_COMPILED_PATH=/var/www/html/storage/framework/views

# Comandos artisan seguros
RUN php artisan config:clear && \
    php artisan view:clear && \
    php artisan storage:link

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]