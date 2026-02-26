# CubeZoo Field Ops API

A clean, production-ready Laravel API for managing field operations with offline-first capabilities. Built following CubeZoo's architectural principles with proper RBAC, queues, and comprehensive testing.

## Quick Start

### Prerequisites
- Docker & Docker Compose
- OR: PHP 8.1+, Composer, SQLite/MySQL

### Setup (Docker)

```bash
# 1. Clone and navigate to project
git clone <repository-url>
cd cubezoo

# 2. Start services
sudo docker-compose up -d

# 3. Install dependencies
sudo docker exec -it laravel_app bash -c "composer install"

# 4. Run migrations
sudo docker exec -it laravel_app bash -c "php artisan migrate"

# 5. (Optional) Seed demo data
sudo docker exec -it laravel_app bash -c "php artisan db:seed"

# 6. Run tests
sudo docker exec -it laravel_app bash -c "php artisan test"

# 7. Start queue worker (in separate terminal)
sudo docker exec -it laravel_app bash -c "php artisan queue:work"
```

### Setup (Local)

```bash
# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Run tests
php artisan test

# Start queue worker
php artisan queue:work

# Serve the API
php artisan serve
```

## Architecture & Design

### Entities

**User**
- `id` (PK)
- `name`, `email`, `password`
- `roles()` - Many-to-many relationship (Admin or Staff)
- Timestamps

**Site**
- `id` (PK)
- `name`, `address` (optional)
- `visits()` - Has many visits
- Timestamps

**Visit**
- `id` (UUID)
- `site_id` (FK)
- `user_id` (FK)
- `visited_at` (ISO 8601 UTC datetime)
- `notes` (max 500 chars)
- `status` enum: `draft`, `submitted`
- `events()` - Has many visit events
- Timestamps

**VisitEvent**
- `id` (PK)
- `visit_id` (FK)
- `event` (string, e.g., "submitted_processed")
- Timestamps

**Running the Queue Worker**:
```bash
# Docker
sudo docker exec -it laravel_app bash -c "php artisan queue:work"

# Local
php artisan queue:work

# With specific queue
php artisan queue:work processing
```

## Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test File
```bash
php artisan test tests/Feature/RBACTest.php
php artisan test tests/Feature/VisitSubmissionTest.php
```

### Test Coverage

**RBACTest.php**
- ✓ Admin can create sites
- ✓ Staff cannot create sites
- ✓ Unauthenticated cannot access protected routes

**VisitSubmissionTest.php**
- ✓ Staff can create visit (draft status)
- ✓ Staff can submit visit (triggers job)
- ✓ Idempotency: submitting twice returns 400
- ✓ Staff cannot submit other users' visits

## Example Workflows

### Mobile Staff Workflow

1. **Login**
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "staff@example.com",
    "password": "password"
  }'
```

2. **Create Visit (Draft)**
```bash
TOKEN="1|abc123token"
curl -X POST http://localhost:8000/api/v1/visits \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "site_id": 1,
    "visited_at": "2026-02-26T14:00:00Z",
    "notes": "Equipment checked. Battery low."
  }'
```

3. **Submit Visit**
```bash
VISIT_ID="550e8400-e29b-41d4-a716-446655440000"
curl -X POST http://localhost:8000/api/v1/visits/$VISIT_ID/submit \
  -H "Authorization: Bearer $TOKEN"
```

### Admin Review Workflow

1. **List All Visits for Site**
```bash
TOKEN="1|admin-token"
curl -X GET "http://localhost:8000/api/v1/sites/1/visits?from=2026-02-01&to=2026-02-28" \
  -H "Authorization: Bearer $TOKEN"
```

2. **Create New Site**
```bash
curl -X POST http://localhost:8000/api/v1/sites \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Branch Office",
    "address": "456 Oak Ave"
  }'
```

## Architecture Decisions & Trade-offs

### 1. **Sanctum for Authentication**
- **Why**: Laravel native, supports token-based auth (critical for mobile)
- **Trade-off**: No OAuth2; sufficient for internal mobile apps
- **Alternative**: Passport (heavier) or custom JWT

### 2. **Job Queue for Submissions**
- **Why**: Decouples external API calls from request handling; enables retries
- **Trade-off**: Eventual consistency (async processing)
- **Idempotency**: Checked via `status = submitted` to prevent double-processing

### 3. **Resource/Transformer Pattern**
- **Why**: Separates API contracts from model structure
- **Trade-off**: Extra layer but enables safe refactoring
- **Benefit**: Version-aware data transformation

### Tests Failing
```bash
# Ensure test database exists
php artisan migrate --env=testing

# Run with verbose output
php artisan test --verbose
```

## License

© 2026 CubeZoo. All rights reserved.
