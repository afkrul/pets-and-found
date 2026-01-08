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

### Developer shortcuts

To make common development tasks easier there are composer scripts available:

- **Serve:** start the local server

```sh
composer run-script serve
```

- **Run tests:** execute the test suite (wrapper around `php artisan test`)

```sh
composer run-script test
```

- **Run PHPUnit directly:**

```sh
composer run-script phpunit
```

- **Lint / code style:** uses Laravel Pint

```sh
composer run-script lint
```

### Git hooks

This repository includes a recommended git hooks directory `.githooks` containing a `pre-commit` hook that runs the `lint` check before commits. To enable these hooks for your repository run:

```sh
composer run-script hooks:install
```

If you ever want to restore the default git hooks behavior:

```sh
composer run-script hooks:uninstall
```

### API Documentation (Swagger / OpenAPI)

An OpenAPI (Swagger) specification is provided at `docs/openapi.yaml`.

To view it locally with Swagger UI:

- Option A: Use the built-in route (serves the YAML file):

```sh
php artisan serve
# then open http://127.0.0.1:8000/api/docs/openapi.yaml in any Swagger UI instance
```

- Option B: Open the YAML in the online Swagger Editor: https://editor.swagger.io/ and paste the contents of `docs/openapi.yaml`.

The spec documents all API endpoints, request/response schemas, and common error responses (200, 401, 403, 404, 422, 429).