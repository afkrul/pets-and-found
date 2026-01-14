# Pets and Found

A simple stateless API created for studying Laravel's structure. The idea is to provide a backend for a service where users can register their pet details, generate a QR code, and, if someone finds the pet, scan the QR code to view information about the pet and contact the owner.

## Technologies Used
- **Laravel 11**: Backend API, authentication, policies, and service container
- **Sanctum**: Stateless API authentication
- **PHPUnit**: Unit and feature testing
- **SQLite**: Default for local development (MySQL/Postgres also supported)

## Architecture & Layered Design

This project follows a **strict layered architecture** to ensure separation of concerns, testability, and maintainability. Each layer has a specific responsibility and should not bypass the layer below it.

### 📦 Layer Overview

```
┌─────────────────────────────────────────────┐
│         Controllers (HTTP Layer)            │  ← Receives requests, returns responses
├─────────────────────────────────────────────┤
│         Form Requests (Validation)          │  ← Validates input, creates DTOs
├─────────────────────────────────────────────┤
│         Actions (Use Cases)                 │  ← Orchestrates business logic
├─────────────────────────────────────────────┤
│         Repositories (Persistence)          │  ← Abstracts data access
├─────────────────────────────────────────────┤
│         Models (Eloquent/Entities)          │  ← ORM layer, database interaction
└─────────────────────────────────────────────┘
```

### 🎯 Layer Responsibilities

#### 1. **Controllers** (`app/Http/Controllers/`)
**Responsibility**: HTTP request/response handling only
- Inject **Actions** (not repositories or models directly)
- Delegate to actions for business logic
- Return **Resources** or JSON responses


#### 2. **Form Requests** (`app/Http/Requests/`)
**Responsibility**: Validation rules and DTO creation
- Define validation rules
- Handle authorization (via policies)
- Provide `dto()` method to create typed DTOs from validated data

#### 3. **DTOs** (`app/Data/`)
**Responsibility**: Immutable data transfer between layers
- Type-safe data structures
- No business logic
- Provide `toArray()` methods for persistence]

#### 4. **Actions** (`app/Actions/`)
**Responsibility**: Single use-case per action (business logic orchestration)
- One invokable action per use-case (Create, Update, Delete, List, Get)
- Inject **Repositories** (not Eloquent models directly)
- Receive **DTOs** instead of raw arrays
- Coordinate between repositories and other services

#### 5. **Repositories** (`app/Repositories/`)
**Responsibility**: Data persistence and retrieval abstraction
- Interface-based design for testability
- Handle all Eloquent/database interactions
- Manage relationships and foreign keys
- Accept DTOs and Models (not raw arrays)

#### 6. **Models** (`app/Models/`)
**Responsibility**: ORM representation of database tables
- Define relationships, casts, and attributes
- Eloquent-specific behavior (observers, factories)

#### 7. **Policies** (`app/Policies/`)
**Responsibility**: Authorization logic
- Determine if a user can perform an action on a resource
- Used by Form Requests and middleware

#### 8. **Resources** (`app/Http/Resources/`)
**Responsibility**: Transform models into JSON responses
- Format API output
- Hide sensitive fields
- Include related data

### 🔒 Design Principles

1. **Dependency Inversion**: Actions depend on repository interfaces, not concrete implementations
2. **Single Responsibility**: Each class has one reason to change
3. **Separation of Concerns**: HTTP, validation, business logic, and persistence are isolated
4. **Testability**: Each layer can be tested independently with mocks

### 🧪 Testing Strategy

- **Unit Tests** (`tests/Unit/`): Mock dependencies (repositories, models) to test business logic in isolation
- **Integration Tests** (`tests/Unit/Repositories/`): Test repositories against a real database
- **Feature Tests** (`tests/Feature/`): Full end-to-end HTTP request/response testing with database

### Running Tests
To run all tests:
```sh
php artisan test
```

To run specific test suites:
```sh
php artisan test --filter=pet        # Pet-related tests
php artisan test --filter=Feature    # Feature tests only
php artisan test --filter=Unit       # Unit tests only
```