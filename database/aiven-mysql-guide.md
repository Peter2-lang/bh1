# Aiven MySQL Setup Guide

This React app now keeps the current login session and records after refresh using browser localStorage.

For real Aiven MySQL storage, do not connect directly from React to MySQL. Browser code would expose your Aiven username, password, host, and port. Use a backend API between the React app and Aiven MySQL.

## 1. Create Aiven MySQL

Create a MySQL service in Aiven, then copy these values from Aiven:

- Host
- Port
- Database name
- User
- Password
- CA certificate if required

## 2. Create Tables

Run this file in your Aiven MySQL console or MySQL client:

```sql
source database/aiven-mysql-schema.sql;
```

## 3. Backend Environment Variables

Use these variables in your backend, not in React:

```bash
MYSQL_HOST=your-aiven-host
MYSQL_PORT=your-aiven-port
MYSQL_DATABASE=madajes_boarding_house
MYSQL_USER=your-aiven-user
MYSQL_PASSWORD=your-aiven-password
MYSQL_SSL=true
```

## 4. API Endpoints Needed

Create backend endpoints for these records:

- `GET /api/bootstrap` loads profile, rooms, tenants, accounts, payments, reports, and schedules.
- `POST /api/login` verifies admin or tenant account.
- `POST /api/rooms`, `PUT /api/rooms/:id`, `DELETE /api/rooms/:id` manages rooms.
- `POST /api/tenants`, `PUT /api/tenants/:id`, `DELETE /api/tenants/:id` manages tenants.
- `POST /api/payments`, `PUT /api/payments/:id/verify`, `DELETE /api/payments/:id` manages payments.
- `POST /api/reports`, `PUT /api/reports/:id`, `DELETE /api/reports/:id` manages reports.
- `POST /api/accounts`, `PUT /api/accounts/:id`, `DELETE /api/accounts/:id` manages user accounts.
- `POST /api/schedules`, `PUT /api/schedules/:id`, `DELETE /api/schedules/:id` manages calendar schedules.

## 5. Important Security Note

Store passwords as hashes in MySQL, not plain text. The schema uses `password_hash` for the production database.