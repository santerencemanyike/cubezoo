# CubeZoo Field Ops API

A clean, production-ready Laravel API for managing field operations with offline-first capabilities. Built following CubeZoo's architectural principles with proper RBAC, queues, and comprehensive testing.

---

# Quick Start (Docker Compose Only)

## Prerequisites

* Docker
* Docker Compose

---

## Full Setup Using Docker

### 1. Clone the repository

```bash
git clone https://github.com/santerencemanyike/cubezoo
cd cubezoo
```

---

### 2. Start Docker containers

```bash
sudo docker compose up -d --build
```

---

### 3. Fix file permissions

**IMPORTANT:** Run this to prevent permission errors

```bash
sh fixperms.sh
```

---

### 4. Enter the Laravel container

```bash
sudo docker exec -it laravel_app bash
```

You will now be inside the container:

```bash
root@container:/var/www/html#
```

---

### 5. Install PHP dependencies

Inside container:

```bash
composer install
```

---

### 6. Generate application key

```bash
php artisan key:generate
```

---

### 7. Run main database migrations, (Optional)

```bash
php artisan migrate
```

---

# Laravel Telescope Installation

Laravel Telescope is used for debugging jobs, requests, and queues.

---

### 8. Install Telescope

Inside container:

```bash
composer require laravel/telescope:^4.6
```

---

### 9. Publish Telescope files

```bash
php artisan telescope:install
```

---

### 10. Run Telescope migrations

```bash
php artisan migrate
```

---

### 11. Access Telescope

Open in browser:

```
http://localhost:8000/telescope
```

---

# Queue Worker

Start the queue worker:

```bash
sudo docker exec -it laravel_app bash -c "php artisan queue:work"
```

---

# Running Tests

Inside container:

```bash
php artisan test
```

or

```bash
sudo docker exec -it laravel_app bash -c "php artisan test"
```

---

# Application Access

| Service     | URL                             |
| ----------- | ------------------------------- |
| Laravel App | http://localhost:8000           |
| Telescope   | http://localhost:8000/telescope |

---

# Architecture & Design

## Entities

### User

* id
* name
* email
* password
* roles
* timestamps

---

### Site

* id
* name
* address
* timestamps

---

### Visit

* id (UUID)
* site_id
* user_id
* visited_at
* notes
* status

Status values:

```
draft
submitted
```

---

### VisitEvent

* id
* visit_id
* event
* timestamps

---

# Queue System

Queue handles visit submission processing.

Run worker:

```bash
sudo docker exec -it laravel_app bash -c "php artisan queue:work"
```

---

# API Example Workflow

---

## Login

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
-H "Content-Type: application/json" \
-d '{
"email":"admin@admin.com",
"password":"password"
}'
```

---

## Create Visit

```bash
curl -X POST http://localhost:8000/api/v1/visits \
-H "Authorization: Bearer TOKEN" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
"site_id":1,
"visited_at":"2026-02-26 14:00:00",
"notes":"Equipment checked"
}'
```

---

## Submit Visit

```bash
curl -X POST http://localhost:8000/api/v1/visits/VISIT_ID/submit \
-H "Authorization: Bearer TOKEN"
```

---

# Admin Workflow

---

## List Site Visits

```bash
curl -X GET http://localhost:8000/api/v1/sites/1/visits \
-H "Authorization: Bearer TOKEN"
```

---

## Create Site

```bash
curl -X POST http://localhost:8000/api/v1/sites \
-H "Authorization: Bearer TOKEN" \
-H "Content-Type: application/json" \
-d '{
"name":"New Site",
"address":"Address"
}'
```

---

# Testing

Run all tests:

```bash
sudo docker exec -it laravel_app bash -c "php artisan test"
```

---

# Telescope Features

Telescope allows you to monitor:

* Jobs
* Requests
* Queries
* Logs
* Exceptions

Access:

```
http://localhost:8000/telescope
```

---

# Common Useful Commands

Enter container:

```bash
sudo docker exec -it laravel_app bash
```

Run migrations:

```bash
php artisan migrate
```

Run queue:

```bash
php artisan queue:work
```

Clear cache:

```bash
php artisan optimize:clear
```

---

# Project Stack

* Laravel
* Docker
* MySQL
* Laravel Queue
* Laravel Telescope

---

# License

© 2026 CubeZoo. All rights reserved.

---
