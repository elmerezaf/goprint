GoPrint Product Management - Laravel Project
Product system backend for GoPrint Hong Kong

## Project Overview

This is the GoPrint printing service website product management backend system, developed using Laravel 10 framework. It provides product data management and API interface services.

## Technology Stack

- Framework: Laravel 10.x
- PHP Version: 8.1+
- Database: MySQL 8.x
- Authentication: Laravel Sanctum (API Token)
- Frontend: Blade Template + Bootstrap 5

## Core Features

- Product listing and management
- User authentication and authorization
- API endpoints
- Database migration management

## Project Structure

laravel/
├── app/
│   ├── Http/Controllers/ProductController.php   # Product Controller
│   ├── Models/Product.php                        # Product Model
│   └── Middleware/                               # Middleware
├── config/                                       # Configuration Files
├── database/migrations/                          # Database Migrations
├── resources/views/                              # Blade Views
├── routes/                                       # Route Definitions
├── storage/                                      # Storage Directory
├── tests/                                        # Test Files
└── public/                                       # Public Files

## Security Features

- CSRF Protection (Laravel built-in)
- SQL Injection Protection (Eloquent ORM auto-handled)
- XSS Protection (Blade template auto-escaping)
- Password Encryption (bcrypt hashing)
- API Authentication (Sanctum Token)

## Installation Steps

cd laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

## Development Log

2026-04-29: Laravel project initialization
2026-04-30: Product management module completed
2026-04-30: View template integration completed

## Related Projects

This system integrates with:

- WordPress Frontend: ../wordpress/
- MVC Prototype: ../02_MVC/

## Deployment Info

- Development Environment: http://localhost:8888/api
- Database: MySQL 8.x (goprint_db)