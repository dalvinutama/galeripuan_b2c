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

# Storage symlink
echo "==> Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Buat migration tabel sessions jika belum ada
echo "==> Ensuring sessions table migration exists..."
php artisan session:table 2>/dev/null || true

# Jalankan migrasi
echo "==> Running migrations..."
php artisan migrate --force

# Seed data awal jika database masih kosong (tidak ada admin)
echo "==> Checking if initial seeding is needed..."
ADMIN_COUNT=$(php artisan tinker --execute="echo \App\Models\Admin::count();" 2>/dev/null | tail -1 | tr -d '[:space:]')
if [ "$ADMIN_COUNT" = "0" ] || [ -z "$ADMIN_COUNT" ]; then
    echo "==> No admin found, running database seeder..."
    php artisan db:seed --force
else
    echo "==> Admin exists (${ADMIN_COUNT}), skipping seeder."
fi

# Optimize cache
echo "==> Caching config, routes, and views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setup complete! Starting Apache..."
exec "$@"
