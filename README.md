# Course Management System

A web-based **Course Management System** built with **Laravel**, **HTML**, **CSS**, and **JavaScript**. This system allows administrators to manage courses, modules, and content efficiently, providing a clean and user-friendly interface.

---

## Features

* Create, read, update, and delete (CRUD) courses.
* Manage course modules and content.
* File uploads for course content (videos, PDFs, etc.).
* User-friendly interface with responsive design.


---

## Requirements

* PHP >= 8.0
* Composer
* MySQL or compatible database
* Laravel >= 10.x

---

## PHP Configuration

To properly handle large files and heavy scripts, update your `php.ini`:

```ini
memory_limit = 500M
upload_max_filesize = 500M
post_max_size = 500M
max_execution_time = 500
```

> ⚠️ Restart your web server after updating `php.ini`.

---

## Installation & Setup

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/course-management-system.git
cd course-management-system
```

2. **Install dependencies**

```bash
composer install

```

3. **Environment setup**

```bash
cp .env.example .env
```

Edit `.env` to set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Generate application key**

```bash
php artisan key:generate
```

5. **Run migrations and seed database**

```bash
php artisan migrate
php artisan db:seed
```

6. **Run the application**

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Usage

* Admin can manage courses, modules, and content from the dashboard.
* Users can view courses and access content based on permissions.
* File uploads are supported for large media content.

---

## Troubleshooting

* **Memory errors**: Ensure `memory_limit` is at least `500M`.
* **File upload errors**: Check `upload_max_filesize` and `post_max_size`.
* **Execution timeout**: Increase `max_execution_time` if needed.

---

## Folder Structure

* `app/` – Application logic (Models, Controllers)
* `resources/views/` – Blade templates (HTML + CSS)
* `public/` – Public assets (CSS, JS, images)
* `routes/web.php` – Web routes
* `database/migrations/` – Database migrations
* `database/seeders/` – Database seeders

---

