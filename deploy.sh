#!/bin/bash

set -e

echo "Deploying..."




#stop application
php8.3 artisan down

git remote add origin git@github.com:SpaceSoft-nn/intech_logistics_backend.git
git pull


# для установки на deploy надо указывать с --no-dev без использование swagger
php8.3 composer.phar install --no-dev --optimize-autoloader

php8.3 artisan migrate --force

#cash
php8.3 artisan config:cache
php8.3 artisan cache:clear
php8.3 artisan event:cache
php8.3 artisan route:cache
php8.3 artisan view:cache

#SWAGGER
# php8.3 artisan l5-swagger:generate

#start application
php8.3 artisan up

echo "Deploying Done!"


