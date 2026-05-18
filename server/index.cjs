const cors = require("cors");
const dotenv = require("dotenv");
const express = require("express");
const fs = require("fs");
const mysql = require("mysql2/promise");
const path = require("path");

dotenv.config();

const app = express();
const port = Number(process.env.PORT || 3000);

app.use(cors());
app.use(express.json({ limit: "5mb" }));

const requiredDbKeys = ["MYSQL_HOST", "MYSQL_PORT", "MYSQL_DATABASE", "MYSQL_USER", "MYSQL_PASSWORD"];
const databaseConfigured = requiredDbKeys.every((key) => Boolean(process.env[key]));

const pool = databaseConfigured
  ? mysql.createPool({
      host: process.env.MYSQL_HOST,
      port: Number(process.env.MYSQL_PORT),
      database: process.env.MYSQL_DATABASE,
      user: process.env.MYSQL_USER,
      password: process.env.MYSQL_PASSWORD,
      waitForConnections: true,
      connectionLimit: 10,
      dateStrings: true,
      ssl:
        process.env.MYSQL_SSL === "true"
          ? {
              ca: process.env.MYSQL_CA ? process.env.MYSQL_CA.replace(/\\n/g, "\n") : undefined,
              rejectUnauthorized: process.env.MYSQL_REJECT_UNAUTHORIZED !== "false",
            }
          : undefined,
    })
  : null;

const asDate = (value) => (typeof value === "string" ? value.slice(0, 10) : new Date(value).toISOString().slice(0, 10));
const asTime = (value) => (typeof value === "string" ? value.slice(0, 5) : "00:00");

const mapRoom = (row) => ({
  id: row.id,
  name: row.name,
  roomNumber: row.room_number,
  type: row.type,
  monthlyRate: Number(row.monthly_rate),
  capacity: Number(row.capacity),
  inclusions: row.inclusions || "",
  status: row.status,
});

const mapTenant = (row) => ({
  id: row.id,
  name: row.name,
  email: row.email,
  phone: row.phone || "",
  roomId: row.room_id,
  startDate: asDate(row.start_date),
  monthlyRent: Number(row.monthly_rent),
  accountId: row.account_id || undefined,
});

const mapAccount = (row) => ({
  id: row.id,
  role: row.role,
  username: row.username,
  password: row.password_hash,
  tenantId: row.tenant_id || undefined,
});

const mapPayment = (row) => ({
  id: row.id,
  tenantId: row.tenant_id,
  amount: Number(row.amount),
  method: row.method,
  reference: row.reference || "",
  date: asDate(row.payment_date),
  status: row.status,
});

const mapReport = (row) => ({
  id: row.id,
  tenantId: row.tenant_id,
  category: row.category,
  title: row.title,
  details: row.details,
  date: asDate(row.report_date),
  status: row.status,
});

const mapSchedule = (row) => ({
  id: row.id,
  title: row.title,
  date: asDate(row.schedule_date),
  time: asTime(row.schedule_time),
  category: row.category,
  details: row.details || "",
  visibleToTenants: Boolean(row.visible_to_tenants),
});

app.get("/api/health", async (_request, response) => {
  if (!pool) {
    response.json({ ok: true, databaseConfigured: false });
    return;
  }

  try {
    await pool.query("SELECT 1");
    response.json({ ok: true, databaseConfigured: true });
  } catch (error) {
    response.status(500).json({ ok: false, databaseConfigured: true, error: error.message });
  }
});

app.get("/api/bootstrap", async (_request, response) => {
  if (!pool) {
    response.json({ configured: false });
    return;
  }

  try {
    const [[profile]] = await pool.query("SELECT * FROM property_profiles ORDER BY id DESC LIMIT 1");
    const [rooms] = await pool.query("SELECT * FROM rooms ORDER BY room_number ASC");
    const [tenants] = await pool.query("SELECT * FROM tenants ORDER BY name ASC");
    const [accounts] = await pool.query("SELECT * FROM accounts ORDER BY role ASC, username ASC");
    const [payments] = await pool.query("SELECT * FROM payments ORDER BY payment_date DESC, created_at DESC");
    const [reports] = await pool.query("SELECT * FROM tenant_reports ORDER BY report_date DESC, created_at DESC");
    const [scheduleItems] = await pool.query("SELECT * FROM schedule_items ORDER BY schedule_date ASC, schedule_time ASC");

    response.json({
      configured: true,
      state: {
        propertyProfile: profile
          ? {
              name: profile.name,
              address: profile.address,
              mapUrl: profile.map_url,
              manager: profile.manager,
              phone: profile.phone,
              notes: profile.notes || "",
            }
          : null,
        rooms: rooms.map(mapRoom),
        tenants: tenants.map(mapTenant),
        accounts: accounts.map(mapAccount),
        payments: payments.map(mapPayment),
        reports: reports.map(mapReport),
        scheduleItems: scheduleItems.map(mapSchedule),
      },
    });
  } catch (error) {
    response.status(500).json({ configured: true, error: error.message });
  }
});

app.put("/api/state", async (request, response) => {
  if (!pool) {
    response.status(503).json({ ok: false, error: "Aiven MySQL environment variables are not configured." });
    return;
  }

  const state = request.body || {};
  const connection = await pool.getConnection();

  try {
    await connection.beginTransaction();
    await connection.query("SET FOREIGN_KEY_CHECKS = 0");
    await connection.query("DELETE FROM schedule_items");
    await connection.query("DELETE FROM payments");
    await connection.query("DELETE FROM tenant_reports");
    await connection.query("DELETE FROM accounts");
    await connection.query("DELETE FROM tenants");
    await connection.query("DELETE FROM rooms");
    await connection.query("DELETE FROM property_profiles");
    await connection.query("SET FOREIGN_KEY_CHECKS = 1");

    if (state.propertyProfile) {
      await connection.query(
        "INSERT INTO property_profiles (name, address, map_url, manager, phone, notes) VALUES (?, ?, ?, ?, ?, ?)",
        [
          state.propertyProfile.name || "",
          state.propertyProfile.address || "",
          state.propertyProfile.mapUrl || "",
          state.propertyProfile.manager || "",
          state.propertyProfile.phone || "",
          state.propertyProfile.notes || "",
        ],
      );
    }

    for (const room of state.rooms || []) {
      await connection.query(
        "INSERT INTO rooms (id, name, room_number, type, monthly_rate, capacity, inclusions, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        [room.id, room.name, room.roomNumber, room.type, room.monthlyRate, room.capacity, room.inclusions || "", room.status],
      );
    }

    for (const tenant of state.tenants || []) {
      await connection.query(
        "INSERT INTO tenants (id, name, email, phone, room_id, start_date, monthly_rent, account_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        [tenant.id, tenant.name, tenant.email, tenant.phone || "", tenant.roomId, tenant.startDate, tenant.monthlyRent, tenant.accountId || null],
      );
    }

    for (const account of state.accounts || []) {
      await connection.query(
        "INSERT INTO accounts (id, role, username, password_hash, tenant_id) VALUES (?, ?, ?, ?, ?)",
        [account.id, account.role, account.username, account.password || "", account.tenantId || null],
      );
    }

    for (const payment of state.payments || []) {
      const tenant = (state.tenants || []).find((item) => item.id === payment.tenantId);
      await connection.query(
        "INSERT INTO payments (id, tenant_id, room_id, amount, method, reference, payment_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        [payment.id, payment.tenantId, tenant?.roomId || null, payment.amount, payment.method, payment.reference || "", payment.date, payment.status],
      );
    }

    for (const report of state.reports || []) {
      await connection.query(
        "INSERT INTO tenant_reports (id, tenant_id, category, title, details, report_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)",
        [report.id, report.tenantId, report.category, report.title, report.details, report.date, report.status],
      );
    }

    for (const item of state.scheduleItems || []) {
      await connection.query(
        "INSERT INTO schedule_items (id, title, schedule_date, schedule_time, category, details, visible_to_tenants) VALUES (?, ?, ?, ?, ?, ?, ?)",
        [item.id, item.title, item.date, item.time, item.category, item.details || "", item.visibleToTenants ? 1 : 0],
      );
    }

    await connection.commit();
    response.json({ ok: true });
  } catch (error) {
    await connection.rollback();
    response.status(500).json({ ok: false, error: error.message });
  } finally {
    connection.release();
  }
});

const distPath = path.join(__dirname, "..", "dist");

if (fs.existsSync(distPath)) {
  app.use(express.static(distPath));
  app.get(/.*/, (_request, response) => {
    response.sendFile(path.join(distPath, "index.html"));
  });
}

app.listen(port, () => {
  console.log(`Madaje's Boarding House server running on port ${port}`);
  console.log(databaseConfigured ? "Aiven MySQL config detected." : "Aiven MySQL config is blank; API will use frontend fallback.");
});