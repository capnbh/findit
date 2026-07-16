# Database

## Summary
The application currently uses a small relational schema centered on user
authentication and session management.

## Tables

### `users`
Stores authenticated user accounts.

Fields:
- `id`
- `name`
- `email`
- `email_verified_at`
- `password`
- `remember_token`
- `created_at`
- `updated_at`

### `password_reset_tokens`
Stores password reset tokens keyed by email address.

Fields:
- `email`
- `token`
- `created_at`

### `sessions`
Stores session state when the database session driver is enabled.

Fields:
- `id`
- `user_id`
- `ip_address`
- `user_agent`
- `payload`
- `last_activity`

### `cache`
The repository includes the cache table migration scaffold through Laravel's
starter setup.

### `jobs`
The repository includes the jobs table migration scaffold for queue support.

## Model Notes
`app/Models/User.php` is the primary Eloquent model.
- Passwords are hashed automatically.
- The model hides sensitive auth fields from serialization.
- `initials()` generates display initials from the user's name.

## Migration Notes
The current schema is intentionally minimal and supports the starter
authentication flows out of the box.

Planned product tables should be added only when the domain model is defined.
If this repository evolves into a game or tracker, the first additions will
likely be the core entity table, event/history table, and any lookup tables.
