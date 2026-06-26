#!/bin/bash
set -e

echo "==> Running Laravel post-start setup..."

DB_HOST_VAL="${DB_HOST:-db}"
DB_PORT_VAL="${DB_PORT:-3306}"

# Tunggu database siap menggunakan TCP port check (lebih reliable)
echo "==> Waiting for database at ${DB_HOST_VAL}:${DB_PORT_VAL}..."
MAX_TRIES=40
COUNT=0
until (echo > /dev/tcp/${DB_HOST_VAL}/${DB_PORT_VAL}) 2>/dev/null; do
    COUNT=$((COUNT + 1))
    if [ $COUNT -ge $MAX_TRIES ]; then
        echo "==> ERROR: Could not connect to database after ${MAX_TRIES} attempts."
        exit 1
    fi
    echo "    DB not ready yet (attempt ${COUNT}/${MAX_TRIES}), retrying in 3s..."
    sleep 3
done
echo "==> Database port is open! Waiting 2s for MySQL to be fully ready..."
sleep 2

# Cek apakah database kosong (cek tabel migrations)
echo "==> Checking if database is empty..."
DB_HOST_VAL="${DB_HOST:-db}"
DB_PORT_VAL="${DB_PORT:-3306}"
DB_USER_VAL="${DB_USERNAME:-root}"
DB_PASS_VAL="${DB_PASSWORD:-secret}"
DB_NAME_VAL="${DB_DATABASE:-gallery_puan}"

TABLE_COUNT=$(mysql --ssl-mode=DISABLED -h "$DB_HOST_VAL" -P "$DB_PORT_VAL" -u "$DB_USER_VAL" -p"$DB_PASS_VAL" -e "SELECT count(*) FROM information_schema.tables WHERE table_schema = '$DB_NAME_VAL';" -N 2>/dev/null || echo 0)

if [ "$TABLE_COUNT" -eq 0 ]; then
    echo "==> Database is empty. Importing database_export.sql to perfectly match local data..."
    if [ -f /var/www/html/database_export.sql ]; then
        mysql --ssl-mode=DISABLED -h "$DB_HOST_VAL" -P "$DB_PORT_VAL" -u "$DB_USER_VAL" -p"$DB_PASS_VAL" "$DB_NAME_VAL" < /var/www/html/database_export.sql
        echo "==> Import complete!"
    else
        echo "==> WARNING: database_export.sql not found!"
    fi
else
    echo "==> Database already contains data (${TABLE_COUNT} tables). Skipping import."
fi

# Pastikan migration cache & sessions table ada (jika belum terbuat dari SQL)
php artisan cache:table 2>/dev/null || true
php artisan session:table 2>/dev/null || true

# Jalankan migrasi jika ada yang tertinggal
echo "==> Running migrations..."
php artisan migrate --force

# Storage symlink
echo "==> Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Optimize cache
echo "==> Caching config, routes, and views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setup complete! Starting Apache..."
exec "$@"
