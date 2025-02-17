# Product Catalog Application

## Overview

This application allows users to manage products with promotion-based pricing. The backend is built with **Laravel**, while the frontend is developed using **Vue.js** with **Vite** for fast development. The app features:

- **Product List**: Displays products with final prices after applying promotions.
- **Pagination**: Handles large datasets by paginating the product list.
- **API Endpoints**: Allows fetching product data via RESTful API.

## Features

- Display products with **promotion-based pricing**.
- Paginate the product list for better performance.
- Fetch product data through **API**.
- **Unit and Feature Tests** to ensure the backend works correctly.
- Built with **Laravel** (Backend) and **Vue.js** (Frontend).

---

## Table of Contents

- [Installation & Setup](#installation--setup)
- [Database Setup](#database-setup)
- [API Endpoints](#api-endpoints)
- [Frontend (Vue.js)](#frontend-vuejs)
- [Testing](#testing)
- [Running the Application](#running-the-application)
- [Conclusion](#conclusion)

---

## Installation & Setup

### Prerequisites

Make sure the following software is installed on your machine:

- **PHP** (version 8.0 or above)
- **Composer**
- **Node.js** and **npm**
- **MySQL** or any preferred database

### Step 1: Clone the Repository

Clone the project repository to your local machine:

```bash
git clone https://your-repository-url.git
cd your-project-directory
```

### Step 2: Set Up the Backend (Laravel)

#### Install Dependencies

Install the necessary **PHP** dependencies:

```bash
composer install
```

#### Set Up Environment

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update your **`.env`** file with the correct database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Generate Application Key

Run this command to generate the application key:

```bash
php artisan key:generate
```

### Step 3: Set Up the Frontend (Vue.js)

#### Install Frontend Dependencies

Make sure **Node.js** and **npm** are installed. Then, run:

```bash
npm install
```

#### Run the Frontend Server

Start the Vue.js development server:

```bash
npm run dev
```

This will start the frontend on **http://localhost:5173**.

### Step 4: Run the Laravel Server

Start the Laravel backend server:

```bash
php artisan serve
```

This will start the backend on **http://localhost:8000**.

---

## Database Setup

### Step 1: Run Migrations

Create the required tables in the database by running:

```bash
php artisan migrate
```

### Step 2: Seed the Database

Insert sample data into the `products` table:

```bash
php artisan db:seed --class=ProductSeeder
```

If the `ProductSeeder` does not exist, create it:

```bash
php artisan make:seeder ProductSeeder
```

In the seeder file (`database/seeders/ProductSeeder.php`), add:

```php
use App\Models\Product;

Product::create([
    'title' => 'Smartphone',
    'description' => 'Latest model smartphone',
    'price' => 499.99,
    'category' => 'electronics',
    'promotion_percentage' => 10
]);

Product::create([
    'title' => 'Laptop',
    'description' => 'High performance laptop',
    'price' => 1000.00,
    'category' => 'electronics',
    'promotion_percentage' => 15
]);
```

Run the seeder:

```bash
php artisan db:seed --class=ProductSeeder
```

### Step 3: Check Data in Database

Verify the data in the database using:

```bash
php artisan tinker
```

Then, run the following to view the products:

```php
Product::all();
```

---

## API Endpoints

### 1. Get All Products (Paginated)

- **Endpoint**: `GET /api/products`
- **Method**: `GET`
- **Description**: Fetches a paginated list of products with their promotion-based pricing.
- **Response**: A paginated list of products with `final_price`.

Example response:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "Smartphone",
      "description": "Latest model smartphone",
      "price": "500.00",
      "category": "electronics",
      "final_price": 450.00,
      "created_at": "2025-02-17T21:31:07.000000Z",
      "updated_at": "2025-02-17T21:31:07.000000Z"
    }
  ],
  "first_page_url": "http://127.0.0.1:8000/api/products?page=1",
  "last_page": 5,
  "next_page_url": "http://127.0.0.1:8000/api/products?page=2",
  "total": 50
}
```

### 2. Get Single Product

- **Endpoint**: `GET /api/products/{id}`
- **Method**: `GET`
- **Description**: Fetch a product by its ID with promotion-based pricing.
- **Response**: A single product with `final_price`.

Example response:

```json
{
  "id": 1,
  "title": "Smartphone",
  "description": "Latest model smartphone",
  "price": "500.00",
  "category": "electronics",
  "final_price": 450.00,
  "created_at": "2025-02-17T21:31:07.000000Z",
  "updated_at": "2025-02-17T21:31:07.000000Z"
}
```

---

## Frontend (Vue.js)

### 1. Product List Page

The product list page fetches data from the **`/api/products`** API and displays products with the **final_price** after applying promotions.

### 2. Pagination Controls

- **Previous Button**: Disables when you're on the first page.
- **Next Button**: Disables when you're on the last page.
- Displays the **current page** and **total pages**.

---

## Testing
*Please note that running the tests may development test data*
*Reseed the application after running tests*
### 1. Run Unit Tests

Run unit tests for controllers or other application logic:

```bash
php artisan test --filter ProductControllerTest
```

### 2. Run Feature Tests

Test feature logic, like API responses and paginated product retrieval:

```bash
php artisan test --filter ProductControllerFeatureTest
```

### 3. Run All Tests

Run all unit and feature tests:

```bash
php artisan test
```
