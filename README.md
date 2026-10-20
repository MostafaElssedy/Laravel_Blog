# 🚀 Modern Laravel Blog & CMS Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11" />
  <img src="https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 3" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" />
  <img src="https://img.shields.io/badge/Bootstrap-4.6-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
  <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License MIT" />
</p>

A robust, enterprise-grade Content Management System (CMS) and modern Blog platform built with **Laravel 11**, **Livewire 3**, and a customized **DeskApp** design system. Designed for high performance, dynamic real-time reactivity, and seamless publishing workflows.

---

## ✨ Key Features

### 🛠️ Admin Dashboard & CMS
- **Real-time Analytics & Stats Grid**: Dynamic KPI cards displaying total articles, category count, newsletter subscribers, and active team members.
- **Symmetrical Scrollable Tables**: Full-width data tables with sticky headers and sleek custom scrollbars for recent articles, category distributions, and newsletter subscribers.
- **Article & Content Publishing**:
  - Full CRUD operations with rich-text content editing.
  - Featured image upload with automatic formatting.
  - Visibility controls (Public vs. Private) with instant status toggles.
  - URL-backed Livewire search, category filter, author filter, and sorting.
- **Hierarchical Category Management**:
  - Two-level taxonomy (Parent Categories & Sub-categories).
  - Drag-and-drop sortable ordering with real-time persistence.
- **User & Team Management (SuperAdmin only)**:
  - Modal-driven user creation and edit workflows.
  - Role-based permissions (**SuperAdmin** vs. **Author**).
  - Instant account status activation/deactivation (`Active` / `Inactive`).
- **General Settings**:
  - Custom blog branding, logo, and favicon upload.
  - SEO Meta tags (keywords and descriptions).
  - Social media integration links.
- **Newsletter Subscription**:
  - Subscriber tracking with active reader counts and subscription dates.

### 🌐 Frontend Website
- **Modern Clean Interface**: Fast, responsive, reader-focused blog layout.
- **Search & Filter**: Real-time search API, trending topics, and category/tag archives.
- **Author Profiles**: Dedicated pages for each content creator showcasing their authored articles.
- **Reader Engagement**: Integrated newsletter subscription and contact form.

---

## 🏗️ Tech Stack & Architecture

- **Backend Framework**: [Laravel 11](https://laravel.com/)
- **Dynamic Frontend**: [Livewire 3](https://livewire.laravel.com/)
- **Styling**: Bootstrap 4.6 + Customized DeskApp CSS & Vanilla Tokens
- **Icons**: Dropways Icon Font & FontAwesome 5
- **Database Support**: MySQL, PostgreSQL, or SQLite
- **Architecture**: Domain-driven MVC with Livewire components and PHP 8 Enums (`UserType`, `UserStatus`)

---

## ⚡ Installation & Quick Start

Follow these steps to set up the project locally:

### 1. Prerequisites
Ensure you have the following installed on your machine:
- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x & **NPM**
- **MySQL** / MariaDB or SQLite

### 2. Clone the Repository
```bash
git clone https://github.com/MostafaElssedy/Laravel_Blog.git
cd Laravel_Blog
```

### 3. Install Backend & Frontend Dependencies
```bash
composer install
npm install
npm run build
```

### 4. Environment Configuration
Copy the example environment file and generate the application encryption key:
```bash
cp .env.example .env
php artisan key:generate
```

Configure your database credentials in the `.env` file:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
*(Or use `DB_CONNECTION=sqlite` for zero-configuration local development)*

### 5. Run Migrations & Seeders
Populate the database with the schema, default administrator account, and realistic category hierarchy:
```bash
php artisan migrate --seed
```

### 6. Start the Local Server
```bash
php artisan serve
```

Visit the application in your browser:
- **Website**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Panel**: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## 🔑 Default Administrator Credentials

Use the following seeded credentials to access the administrative dashboard:

| Field | Value |
|---|---|
| **URL** | `/admin/login` |
| **Email** | `admin@gmail.com` |
| **Password** | `12345` |
| **Role** | `SuperAdmin` |

> ⚠️ **Note**: For production deployments, remember to change these credentials immediately from the **Profile** section!

---

## 📂 Project Structure Overview

```
├── app/
│   ├── Http/Controllers/     # AuthController, AdminController, PostController, BlogController
│   ├── Livewire/             # AdminPosts, AdminUsers, Categories, HeaderProfile
│   ├── Models/               # User, Post, Category, ParentCategory, Subscriber, GeneralSetting
│   └── UserType.php          # PHP 8 Enum (SuperAdmin, Author)
├── database/
│   ├── migrations/           # Database schema migrations
│   └── seeders/              # UserSeeder, CategorySeeder, DatabaseSeeder
├── public/
│   ├── Back/                 # Admin panel vendor styles, fonts, and scripts
│   └── images/               # Upload directories (posts, users, settings)
├── resources/
│   └── views/
│       ├── Back/             # Admin Blade templates & layout components
│       ├── Front/            # Website Blade views & layouts
│       └── livewire/         # Livewire component Blade views
└── routes/
    └── web.php               # Protected admin & public frontend routes
```

---

## 🛡️ License

This project is open-source software licensed under the [MIT License](LICENSE).
