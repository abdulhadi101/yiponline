# Stage 1: Composer dependencies
FROM composer:2 AS composer_stage

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

COPY . .

RUN composer dump-autoload --optimize --classmap-authoritative


# Stage 2: Frontend assets (Vite)
FROM node:20-alpine AS node_stage

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./vite.config.js

RUN npm run build


# Stage 3: Runtime image (Nginx + PHP-FPM + Supervisor)
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    bash \
    shadow

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    gd \
    zip \
    intl \
    mbstring \
    xml \
    simplexml \
    opcache \
    pcntl \
    exif

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY docker/php/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini
COPY docker/php/uploads.ini $PHP_INI_DIR/conf.d/uploads.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .
COPY --from=composer_stage --chown=www-data:www-data /app/vendor ./vendor
COPY --from=node_stage --chown=www-data:www-data /app/public/build ./public/build

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache/data \
    storage/logs \
    bootstrap/cache \
    database \
    /var/log/supervisor \
    /var/run/php-fpm \
    /var/lib/nginx/tmp/client_body \
    /var/lib/nginx/tmp/proxy \
    /var/lib/nginx/tmp/fastcgi \
    /var/lib/nginx/tmp/uwsgi \
    /var/lib/nginx/tmp/scgi \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database /var/lib/nginx /var/run /var/log/supervisor \
    && chmod -R 775 storage bootstrap/cache database /var/lib/nginx /var/run /var/log/supervisor

EXPOSE 80

CMD ["/start.sh"]
