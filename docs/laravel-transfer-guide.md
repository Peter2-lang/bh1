# Laravel Blade Transfer Guide

The Laravel Blade pages were added under `resources/views`.

## Files Added

- `resources/views/layouts/boarding-house.blade.php`
- `resources/views/partials/sidebar.blade.php`
- `resources/views/partials/header.blade.php`
- `resources/views/partials/panel.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/tenants.blade.php`
- `resources/views/admin/rooms.blade.php`
- `resources/views/admin/payments.blade.php`
- `resources/views/admin/calendar.blade.php`
- `resources/views/admin/reports.blade.php`
- `resources/views/admin/users.blade.php`
- `resources/views/admin/profile.blade.php`
- `resources/views/tenant/dashboard.blade.php`
- `resources/views/tenant/calendar.blade.php`
- `resources/views/tenant/payment.blade.php`
- `resources/views/tenant/reports.blade.php`
- `resources/views/tenant/profile.blade.php`

## Routes

A simple route file was added at `routes/web.php`. In a real Laravel project, replace the `Route::view(...)` entries with controller methods once your models and database logic are ready.

## Aiven MySQL In Laravel

Set these values in your Laravel `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

If Aiven requires SSL, add:

```env
MYSQL_ATTR_SSL_CA=/path/to/ca.pem
```

## Empty Tables

Use this SQL to create empty tables:

`database/aiven-mysql-schema.sql`

Use this SQL to clear all records:

`database/empty-records.sql`

## Background Image

The login page uses:

`public/images/madajes-boarding-house-bg.jpg`

Keep that filename to preserve the current background image.