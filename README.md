
# 📝 Advanced Task Management API (Laravel 10)

## 🚀 Overview

This project is a **Task Management RESTful API** built with **Laravel 10**.  
It allows users to create, update, delete, list, and search tasks with advanced features like priority handling, full-text search, and notification scheduling.

---

## 🛠️ Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/Ahmedlotfe/Advanced-Task-Management-API.git
cd Advanced-Task-Management-API
```

### 2. Install dependencies
```bash
composer install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure database
Edit `.env` and set your DB credentials:
```env
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations and seeders
```bash
php artisan migrate --seed
```

### 6. Start the server
```bash
php artisan serve
```

---

## ✨ Features

### 🔹 Basic Features

- ✅ **Task Creation**: title, optional description, due date (future), default status: `Pending`.
- ✅ **Task Updates**: update status (`Pending`, `In Progress`, `Completed`, `Overdue`) with validation logic.
- ✅ **Task Deletion**: soft deletes only, to preserve data integrity.
- ✅ **Task Listing**:
  - Filter by status, due date range
  - Sort by: priority, due date, created_at

### 🔹 Advanced Features

- 📧 **Email Notification**: scheduled 24h before due date using Laravel Queues + Custom Artisan Command.
- 🔍 **Full-Text Search**: using MySQL `MATCH ... AGAINST()` on `title` & `description`.
- 🔼 **Task Prioritization**: supports `Low`, `Medium`, `High` + sorting support.

---

## ⚙️ Design Decisions

- ✅ **Repository Pattern** for business logic separation.
- ✅ **Form Request Validation** for clean controller code.
- ✅ **API Resources** for consistent & structured JSON responses.
- ✅ **Custom Exception Handling** where needed.
- ✅ **Artisan Command** for hourly notifications.
- ✅ **Rate Limiting** on task creation route (throttle middleware).
- ✅ **Unit & Feature Tests** using Laravel's built-in testing tools.

---

## 📦 API Endpoints Summary

| Method | Endpoint             | Description                     |
|--------|----------------------|---------------------------------|
| GET    | `/api/tasks`         | List tasks with filters/sorting |
| POST   | `/api/tasks`         | Create a new task               |
| GET    | `/api/tasks/{id}`    | Get task by ID                  |
| PUT    | `/api/tasks/{id}/status` | Update task status          |
| DELETE | `/api/tasks/{task}`    | Soft delete task                |
| GET    | `/api/task/search`  | Full-text search                 |

---

## 🧪 Testing

```bash
php artisan test
```

- Unit tests for core business logic.
- Feature tests for all endpoints.
- Seeders & factories used for test data generation.

---

## 📅 Scheduler

To enable hourly notifications, add this to your server's crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📌 Notes

- Laravel version: `10.x`
- PHP version: `>=8.1`
- DB: MySQL (with full-text indexing)
- Queues: Database driver

