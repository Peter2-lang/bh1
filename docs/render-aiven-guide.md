# Render + Aiven MySQL Deployment Guide

The app includes a Node/Express server in `server/index.cjs`. The server serves the React build and connects to Aiven MySQL through environment variables.

## Where To Put Aiven MySQL Values

In Render, open your Web Service, then go to **Environment** and fill these keys:

- `MYSQL_HOST`: your Aiven MySQL host
- `MYSQL_PORT`: your Aiven MySQL port
- `MYSQL_DATABASE`: your Aiven database name
- `MYSQL_USER`: your Aiven MySQL username
- `MYSQL_PASSWORD`: your Aiven MySQL password
- `MYSQL_SSL`: keep `true`
- `MYSQL_REJECT_UNAUTHORIZED`: use `false` if you are not pasting the CA certificate
- `MYSQL_CA`: optional Aiven CA certificate

The blank template is in `.env.example` and `render.yaml`.

## Render Settings

Use these values if you create the service manually:

- Environment: `Node`
- Build Command: `npm install && npm run build`
- Start Command: `node server/index.cjs`

## Create Tables In Aiven

Run this SQL file in Aiven MySQL before deploying:

`database/aiven-mysql-schema.sql`

## Data Sync Behavior

The frontend first tries to load from `/api/bootstrap`.

If Aiven variables are blank, the app opens with empty records.

If Aiven variables are filled, only records from MySQL are shown. The browser does not load demo records from localStorage.

The browser only remembers the signed-in account id and current tab after refresh. Rooms, tenants, accounts, payments, reports, schedules, and profile data come from Aiven MySQL.

If the Aiven tables are empty, the app will show empty records. Create your first admin account directly in MySQL Workbench or with your own Laravel/backend seeder.

## MySQL Workbench Connection

Use the same Aiven values in MySQL Workbench:

- Hostname: `MYSQL_HOST`
- Port: `MYSQL_PORT`
- Username: `MYSQL_USER`
- Password: `MYSQL_PASSWORD`
- Default Schema: `MYSQL_DATABASE`

If Aiven requires SSL, open the SSL tab in MySQL Workbench and attach the Aiven CA certificate.

## Keep Records Empty

The schema file creates tables only and does not insert sample records:

`database/aiven-mysql-schema.sql`

To clear all records again, run:

`database/empty-records.sql`

## Image Background

The login background uses:

`public/images/madajes-boarding-house-bg.jpg`

Do not rename it if you want to keep the current image path. The layout uses responsive cover sizing for desktop and phone.