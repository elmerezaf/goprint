# API Documentation Setup Guide

## Installation Steps

### 1. Install the Swagger Package

Run this command in your Laravel project directory:

```bash
composer require darkaonline/l5-swagger
```

### 2. Publish the Configuration Files

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

### 3. Generate the API Documentation

```bash
php artisan l5-swagger:generate
```

### 4. Access the Documentation

Visit: `http://localhost:8000/api/documentation`

## API Controllers with Annotations

Below are the annotated controllers for your API.

---

## API Documentation Annotations

Now let's create/update the necessary controller files with Swagger annotations.
