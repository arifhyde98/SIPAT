#!/bin/sh
set -e

if [ ! -d vendor ]; then
    composer install --no-interaction --prefer-dist
fi

mkdir -p writable/cache writable/debugbar writable/logs writable/session writable/uploads public/uploads
chown -R www-data:www-data writable public/uploads

exec "$@"
