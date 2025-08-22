#!/usr/bin/env bash
set -e

PORT="${PORT:-8080}"
# stel Apache untuk pakai $PORT (Listen & VirtualHost)
sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s!<VirtualHost \*:[0-9]+>!<VirtualHost *:${PORT}>!" /etc/apache2/sites-available/000-default.conf

# Laravel optimize (jangan gagal kalau belum ada .env)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

exec "$@"
