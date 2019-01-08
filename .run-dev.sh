#!/bin/bash
set -xe

composer install

# Migrate data
php artisan migrate

# Cache data
php artisan config:cache
php artisan view:clear
php artisan cache:clear
