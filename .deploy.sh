#!/bin/bash
set -xe

curl -sS https://getcomposer.org/installer | php
php composer.phar install

# Migrate data
php artisan migrate

# Cache data
php artisan config:cache
php artisan view:clear
php artisan cache:clear
