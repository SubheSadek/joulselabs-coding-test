
---

## 📜 MANIFESTO.md — Engineering Manifesto

This one is important — it shows how you think as an engineer.

```md
# SellNow — Engineering Manifesto

This project was intentionally built without a full framework (Laravel, Symfony) to demonstrate understanding of:

- HTTP request lifecycle
- Routing & dispatching
- Dependency injection
- Validation pipelines
- Database abstraction
- Security fundamentals
- Application layering

The goal is clarity over cleverness.

---

## 🧱 Architectural Principles

### 1. Separation of Concerns

The system follows a layered architecture:

- **Controllers** — Handle HTTP requests and responses only  
- **Services** — Business logic (checkout, cart, upload, validation)  
- **Repositories** — Database access, queries only  
- **Domain** — Pure data models (Product, User)  
- **Core** — Framework-like infrastructure (Router, Container, CSRF, Validation)

This prevents:
- Fat controllers  
- SQL inside controllers  
- Business logic in views  

---

## 🔌 Dependency Injection

A simple container is used to resolve dependencies:

- Controllers do not create services directly
- Services do not create repositories directly
- Everything depends on abstractions, not concrete construction

This enables:
- Easier testing
- Clear dependency flow
- Loose coupling

---

## 🔐 Security First

Security was treated as a core requirement:

### SQL Injection Protection
- All queries use **prepared statements**
- No raw query execution is exposed

### CSRF Protection
- Token generated per session
- Verified on all POST / DELETE routes
- Included in AJAX cart requests

### File Upload Safety
- MIME type validation
- Size limits enforced
- Files stored outside codebase structure

### Output Escaping
- Twig auto-escaping prevents XSS

---

## 🗃️ Database & Migrations

Instead of a single schema file, migrations are used:

- Versioned SQL files
- Migration tracking via `migrations` table
- Foreign keys and indexes enforced at DB level

This simulates Laravel-style migrations while remaining framework-free.

Supported engines:
- PostgreSQL (primary)
- MySQL
- SQLite (assessment mode)

---

## 🔁 Pagination Strategy

Pagination is handled via:

- `page`, `limit`, `offset` calculation in service layer
- Bound integer parameters in SQL
- Frontend supports progressive loading ("Load more" ready)

This avoids:
- Large result sets
- Memory exhaustion
- Slow public profile pages

---

## 🧾 Logging & Observability

A dedicated `TransactionLogger` writes:

- Timestamped checkout logs
- Payment provider used
- User or guest context

This simulates audit logging found in real commerce systems.

---

## ⚠️ Known Trade-offs (Intentional)

Some imperfections are intentional to reflect assessment constraints:

- No ORM (manual mapping instead)
- No queue system
- No real payment gateway
- Minimal error pages (no fancy 500 templates)

The focus is correctness, safety, and clarity.

---

## 🎯 Design Philosophy

- Prefer explicit code over magic
- Prefer safety over performance
- Prefer readability over abstraction
- Build what you understand

---

## 🧠 Final Notes

This project demonstrates:

- Backend architecture skills
- Database design & migrations
- Security awareness
- Framework-level understanding without using a framework

It is not a production system — it is an engineering exercise.

---

Built with discipline and intention.
