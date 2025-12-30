#!/bin/bash

# Build script para Render - B&R Tecnología Catálogo
echo "=== Instalando dependencias de Composer ==="
composer install --no-dev --optimize-autoloader

echo "=== Configurando permisos de storage ==="
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "=== Creando enlace simbólico de storage ==="
php artisan storage:link --force || true

echo "=== Ejecutando migraciones ==="
php artisan migrate --force

echo "=== Creando usuario administrador y datos iniciales ==="
php artisan db:seed --force

echo "=== Limpiando productos (máx 3 por categoría) ==="
php artisan products:cleanup --limit=3

echo "=== Limpiando y cacheando configuración ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Build completado ==="
echo "📧 Admin: eduardodlcruz05@gmail.com"
echo "🔑 Pass: Admin2025BR"
