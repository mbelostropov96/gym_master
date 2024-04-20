# GACHI GYM

```bash

# clone the repo
git clone ...
cd gachi_gym


# install dependencies
composer install
npm install
npm run build


# copy default config
cp .env.example .env


# laravel, database preparations
php artisan key:generate
php artisan migrate
php artisan db:seed


# start web server
php artisan serve
```
