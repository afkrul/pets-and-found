# Pets and Found

A simple stateless API created for studying Laravel's structure. The idea is to provide a backend for a service where users can register their pet details, generate a QR code, and, if someone finds the pet, scan the QR code to view information about the pet and contact the owner.

## Technologies Used
- **Laravel**: Backend API, authentication, policies, actions, and service container
- **Sanctum**: Stateless API authentication
- **PHPUnit**: Unit and feature testing
- **SQLite**: Default for local development (MySQL/Postgres also supported)

## Architecture
- **Domain-Driven Actions**: All business logic (create, update, delete, list, get) is encapsulated in `app/Actions/` for testability and clarity.
- **Policies**: Authorization logic is handled via Laravel policies, auto-discovered for each model.
- **Form Requests**: Validation and authorization are managed in custom request classes.
- **Controllers**: Thin controllers delegate to actions and return JSON responses for API endpoints.
- **Testing**: Unit tests mock dependencies; feature tests use the database for end-to-end coverage.


### Running Tests
To run unit and feature tests:
```sh
php artisan test
```



