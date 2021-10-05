## xendit-demo-2nativePHP
Vanilla PHP version of Xendit Demo

## Requirement
Composer is required. Get composer from https://getcomposer.org/download/

## Installation
After cloning this repository, just do:
```bash
composer install
```
Copy .env.example file into .env the same directory
```bash
cp .env.example .env
```
Update the .env file you just copied for your own API_KEY.
Go to public directory then run the internal development server to try
```bash
cd src/public
php -S localhost:8080
```
