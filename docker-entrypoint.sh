#!/bin/bash
set -e

echo "==> Running Laravel post-start setup..."

# Tunggu database siap menggunakan mysqladmin ping
echo "==> Waiting for database connection..."
MAX_TRIES=30
COUNT=0
until mysqladmin ping -h"${DB_HOST:-db}" -P"${DB_PORT:-3306}" -u"${DB_USERNAME:-root}" -p"${DB_PASSWORD:-secret}" --silent 2>/dev/null; do
    COUNT=$((COUNT + 1))
    if [ $COUNT -ge $MAX_TRIES ]; then
        echo "==> ERROR: Could not connect to database after ${MAX_TRIES} attempts. Exiting."
        exit 1
    fi
    echo "    DB not ready yet (attempt ${COUNT}/${MAX_TRIES}), retrying in 2s..."
    sleep 2
done
echo "==> Database is ready!"

# Storage symlink
echo "==> Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Jalankan migrasi
echo "==> Running migrations..."
php artisan migrate --force

# Optimize cache
echo "==> Caching config, routes, and views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setup complete! Starting Apache..."
exec "$@"
