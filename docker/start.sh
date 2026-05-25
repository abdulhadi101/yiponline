#!/bin/sh
set -e

mkdir -p \
  /var/www/html/storage/framework/sessions \
  /var/www/html/storage/framework/views \
  /var/www/html/storage/framework/cache/data \
  /var/www/html/storage/logs \
  /var/www/html/bootstrap/cache \
  /var/www/html/database

touch /var/www/html/database/database.sqlite

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

php artisan filament:upgrade || true

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

if [ "$RUN_MIGRATIONS" = "true" ]; then
  php artisan migrate --seed --force || echo "Migration failed, continuing..."
fi

exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
