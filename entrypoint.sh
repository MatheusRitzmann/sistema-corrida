#!/bin/sh

echo "Instalando caches..."
php artisan optimize:clear

php artisan session:table
php artisan migrate
php artisan db:seed 

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Iniciando aplicação..."

php artisan serve --host=0.0.0.0 --port=10000