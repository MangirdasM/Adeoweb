## Description
Service which returns product recommendations depending on current weather.

## Technologies

- PHP 8.1.5
- MySQL
- Laravel 9

## Setup
```
# Download or clone project
git clone https://github.com/MangirdasM/Adeoweb.git

# Install dependancies
composer install

# Create .env file with you database information

# Migrate database
php artisan migrate:fresh

# Seed databases
php artisan db:seed

# Generate key
php artisan key:generate

# Create localhost
php artisan serve
```

## Usage
Api call 
```
{host}/api/products/recommend/{city}
```
Example
```
http://127.0.0.1:8000/api/products/recommend/kaunas
```