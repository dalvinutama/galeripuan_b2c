#!/bin/bash
set +e

echo "==> Running Laravel post-start setup..."

DB_HOST_VAL="${DB_HOST:-db}"
DB_PORT_VAL="${DB_PORT:-3306}"
DB_USER_VAL="${DB_USERNAME:-root}"
DB_PASS_VAL="${DB_PASSWORD:-secret}"
DB_NAME_VAL="${DB_DATABASE:-gallery_puan}"

# Tunggu database siap menggunakan TCP port check
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
echo "==> Database port is open! Waiting 3s for MySQL to be fully ready..."
sleep 3

# Cek apakah database kosong
echo "==> Checking if database is empty..."
TABLE_COUNT=$(mysql --skip-ssl -h "$DB_HOST_VAL" -P "$DB_PORT_VAL" -u "$DB_USER_VAL" -p"$DB_PASS_VAL" \
    -e "SELECT count(*) FROM information_schema.tables WHERE table_schema = '$DB_NAME_VAL';" \
    -N 2>/dev/null)
TABLE_COUNT=${TABLE_COUNT:-0}

if [ "$TABLE_COUNT" -eq 0 ]; then
    echo "==> Database is empty. Importing database_export.sql..."
    if [ -f /var/www/html/database_export.sql ]; then
        mysql --skip-ssl -h "$DB_HOST_VAL" -P "$DB_PORT_VAL" -u "$DB_USER_VAL" -p"$DB_PASS_VAL" \
            "$DB_NAME_VAL" < /var/www/html/database_export.sql
        echo "==> Import complete!"
    else
        echo "==> WARNING: database_export.sql not found, running migrations + seeder..."
        php artisan migrate --force
        php artisan db:seed --force
    fi
else
    echo "==> Database has ${TABLE_COUNT} tables. Running any pending migrations..."
    php artisan migrate --force
fi

# Buat tabel sessions jika SESSION_DRIVER=database
if [ "${SESSION_DRIVER}" = "database" ]; then
    echo "==> Ensuring sessions table exists..."
    php artisan session:table 2>/dev/null || true
    php artisan migrate --force
fi

# Buat tabel cache jika CACHE_DRIVER=database
if [ "${CACHE_DRIVER}" = "database" ]; then
    echo "==> Ensuring cache table exists..."
    php artisan cache:table 2>/dev/null || true
    php artisan migrate --force
fi

# Storage symlink
echo "==> Creating storage symlink..."
php artisan storage:link --force 2>/dev/null

# Fix permissions for volume mounts
echo "==> Fixing storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Optimize cache
echo "==> Optimizing..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setup complete! Starting Apache..."
exec "$@"
