# Transportation Management App

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)](https://www.php.net/)
[![Tests](https://github.com/your-username/transportation-app/actions/workflows/tests.yml/badge.svg)](https://github.com/your-username/transportation-app/actions)
[![Coverage](https://img.shields.io/badge/Coverage-80%25-green.svg)]()

A Laravel + Filament application for managing transportation operations (drivers, vehicles, trips).  
This project was built as part of a technical challenge and includes optimized business logic, overlapping trip validation, and a Pest test suite with high coverage.

---

## 🚀 Setup Instructions

### Requirements
- PHP 8.2+
- Composer
- MySQL/PostgreSQL
- Node.js & npm (for frontend assets)

### Installation
```bash
git clone https://github.com/your-repo/transportation-app.git
cd transportation-app

# Install backend dependencies
composer install

# Copy environment file
cp .env.example .env
php artisan key:generate

# Set up database in .env
DB_DATABASE=transportation
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --seed

# Install frontend dependencies
npm install && npm run build

# Run the development server
php artisan serve
