#!/bin/sh
set -e

# ensure project directory exists
if [ -d "/var/www/html" ]; then
  # fix permissions for Laravel writable directories
  chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
  chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true
fi

# make php-fpm listen on all interfaces for container networking
if [ -f "/usr/local/etc/php-fpm.d/www.conf" ]; then
  sed -ri "s/^listen\s*=.*/listen = 0.0.0.0:9000/" /usr/local/etc/php-fpm.d/www.conf || true
fi

# Exec the main container command (php-fpm)
exec "$@"
