#!/bin/bash
set -e

echo "==> Running Laravel post-start setup..."

# Tunggu database siap
echo "==> Waiting for database..."
until php artisan db:show --no-ansi 2>/dev/null | grep -q "Platform"; do
    sleep 2
    echo "    DB not ready, retrying..."
done
echo "==> Database is ready."

# Jalankan migrasi
echo "==> Running migrations..."
php artisan migrate --force

# Buat tabel session jika SESSION_DRIVER=database
echo "==> Checking session table..."
php artisan session:table 2>/dev/null || true
php artisan migrate --force

# Storage symlink
echo "==> Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Optimize cache
echo "==> Optimizing..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setup complete. Starting Apache..."
exec "$@"
