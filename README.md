# Blog App with Social Login (Laravel)

A Laravel 12 blog and admin application with social sign-in (Google, GitHub, LinkedIn, and Facebook). It includes role-based permissions, post management, project tracking, user administration, reports, site settings, and a Product REST API with Redis caching.

## Features

**Authentication**

- Email and password registration and login
- Social login with Google, GitHub, LinkedIn, and Facebook through Laravel Socialite
- Forgot-password and reset-password emails
- New public registrations get the `User` role

**Roles and permissions**

- Seeded roles: Super Admin, Admin, Manager, Editor, and User
- Permissions are checked by the `permission` middleware on each route
- Super Admin manages roles, permissions, and system settings
- Policies control access to posts, projects, and users

**Posts**

- Create, edit, and delete posts
- Assign posts to users
- Dashboard shows all posts to Super Admin and Editor, and assigned posts to User

**Projects**

- Create, view, edit, and delete projects
- Assign users to projects
- Update project status (permission-controlled)

**Users**

- Create, edit, and assign roles to users
- Soft-delete users, view trashed users, restore them, or permanently delete them

**Reports and settings**

- Reports page (requires `reports.view`)
- Site settings, including the site name shown on the home page (requires `settings.manage`)

**Product API**

- `GET /api/products` lists active products, cached in Redis or the configured cache store
- `GET /api/products/search?q=...` searches active products
- Full resource routes for create, show, update, and delete, with cache invalidation
- Page at `/products` for managing products through the API

**Background jobs**

- A demo queued job (`RedisQueueDemoJob`) logs a message. It shows Redis-backed queues.

## Tech Stack

- PHP 8.2 or newer and Laravel 12
- Laravel Socialite and `socialiteproviders/linkedin`
- Laravel Sanctum for API authentication
- Predis for Redis
- Blade views with Vite 7 and Tailwind CSS 4
- Axios for frontend API calls
- PHPUnit for tests

## Project Structure

```
├── app/
│   ├── Http/Controllers/       # Posts, projects, users, roles, permissions, reports, settings, social auth, password reset
│   ├── Http/Controllers/Api/   # Product API
│   ├── Http/Middleware/        # CheckPermission
│   ├── Models/                 # User, Post, Project, Role, Permission, Product, Setting, SocialAccount
│   ├── Policies/               # Post, Project, User
│   ├── Services/               # ProductService
│   └── Jobs/                   # RedisQueueDemoJob
├── config/                     # services.php holds OAuth provider settings
├── database/
│   ├── migrations/
│   └── seeders/                # RolePermissionSeeder, DatabaseSeeder
├── resources/
│   ├── views/                  # Blade templates for every module
│   └── js/, css/               # Frontend entry points
├── routes/
│   ├── web.php                 # Web routes and permission-protected pages
│   └── api.php                 # Product and Sanctum routes
├── docs/Product_API_Redis_Guide.pdf
└── tests/Feature/ProductApiTest.php
```

## Getting Started

### Prerequisites

- PHP 8.2 or newer with the usual Laravel extensions
- Composer
- Node.js with npm
- A database (MySQL, PostgreSQL, or SQLite)
- Redis, if you use Redis for cache or queues

### 1. Install

```bash
git clone <repository-url>
cd blog-app-with-socail-login-in-laravell-main
cp .env.example .env
composer install
php artisan key:generate
npm install
```

Or run the bundled setup script, which covers the steps above and the migration:

```bash
composer run setup
```

### 2. Configure `.env`

Set the database and mail settings, then add the OAuth credentials:

```env
APP_URL=http://localhost:8000

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback

LINKEDIN_CLIENT_ID=
LINKEDIN_CLIENT_SECRET=
LINKEDIN_REDIRECT_URI=http://localhost:8000/auth/linkedin/callback

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback

SUPER_ADMIN_NAME="Super Admin"
SUPER_ADMIN_EMAIL=admin@example.com
SUPER_ADMIN_PASSWORD=use-a-strong-unique-password
```

Each redirect URI must also be added to the matching OAuth app in the provider's developer console.

### 3. Migrate and seed

```bash
php artisan migrate --seed
```

This creates the tables, roles, permissions, and the Super Admin account.

### 4. Run

```bash
php artisan serve
npm run dev
```

Open http://localhost:8000.

Or start the full development environment (server, queue, logs, and Vite) with:

```bash
composer run dev
```

## Testing

```bash
php artisan test
```

The Product API tests cover listing and caching, search, create, update, and delete.

## Notes Before Production

- Set `APP_DEBUG=false` and use a strong `APP_KEY`.
- Use a production database and mail service.
- Keep OAuth secrets and the Super Admin password out of the repository.
- Run `npm run build` before deploying so the Vite assets are available.
- Keep the `.env` file out of version control. The `.gitignore` already excludes it.
