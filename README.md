# SellNow — Lightweight PHP Marketplace (Assignment Project)

SellNow is a lightweight marketplace application built with **pure PHP**, **PDO**, and **Twig**, inspired by Laravel-style architecture but implemented from scratch.

The project demonstrates:
- MVC-style separation
- Custom routing & container
- Secure authentication & CSRF protection
- File uploads
- Pagination
- Database migrations
- Transaction logging
- PostgreSQL / MySQL / SQLite compatibility

This project was developed as part of a technical assessment.

---

## 🚀 Features

- User registration & login
- Public seller profile pages
- Product listing with pagination
- File & image upload for products
- Shopping cart (session-based)
- Mock checkout & payment flow
- Transaction logging
- CSRF protection on forms & AJAX
- Custom validation engine (Laravel-inspired rules)
- Migration system (versioned SQL files)

---

## 🛠️ Tech Stack

- PHP 8+
- PDO (PostgreSQL / MySQL / SQLite supported)
- Twig (templating)
- jQuery (AJAX cart actions)
- Bootstrap 5
- Dotenv for environment configuration

---

## 📂 Project Structure

```bash
sellnowproject/
├── public/ # Front controller & public assets
├── src/
│ ├── Controllers/
│ ├── Services/
│ ├── Repositories/
│ ├── Domain/
│ ├── Core/ # Router, Container, Validation, CSRF, Logger
│ └── Config/
├── templates/ # Twig templates
├── routes/ # Route definitions
├── database/
│ ├── migrations/ # Versioned SQL migrations
│ ├── migrate.php # Migration runner
│ └── schema.sql
├── storage/
│ └── logs/
└── composer.json
```

---


## � Docker Installation

If you prefer using Docker, a `compose.yaml` and `Makefile` are provided for ease of use.

### 1. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Update `.env` to use the Docker database settings:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=sell_now
DB_USERNAME=sell_now
DB_PASSWORD=secret
```

### 2. Start Containers

Use the Makefile to build and start the services:

```bash
make build
make up
```

### 3. Install Dependencies

Run composer install within the Docker container:

```bash
make composer install
```

### 4. Run Migrations

Set up the database schema:

```bash
make migrate
```

### 5. Access the App

The application will be available at: [http://sellnow.localhost](http://sellnow.localhost)

---

## ⚙️ Manual Installation

### 1. Clone & Install Dependencies

```bash
composer install
```

### 2. Create .env

Example for PostgreSQL:

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sell_now
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 3. Create Database

PostgreSQL:

CREATE DATABASE sell_now;

### 4. Run Migrations

```bash
php database/migrate.php
```

This will:

1. Create the migrations table

2. Run all migration files in order

3. Apply foreign keys and indexes

### 5. Run the App

From project root:

```bash
php -S localhost:8000 -t public
```

Open:

```bash
http://localhost:8000
```

---

## �🔐 Security Notes

This project includes:

1. Prepared statements everywhere (PDO, no raw queries)

2. CSRF protection for all POST / DELETE requests

3. File upload validation (type + size)

4. Session-based authentication

5. Escaped output via Twig

6. Known limitations (intentional for assessment clarity):

7. No password reset

8. No role system

9. No payment gateway integration (mock only)

---

## 🧪 Test Accounts

1. Register a new account via /register
2. Create products via dashboard
3. Visit public shop at:

```bash
/{username}/shop
```