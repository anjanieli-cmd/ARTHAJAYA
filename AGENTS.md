# AGENTS.md — Arthajaya

## Project Overview

Arthajaya is an Indonesian business accounting web application built with **Laravel 13** (PHP 8.3+). It provides company onboarding, bank account setup, and a finance dashboard. The app is multi-tenant at the Company level — each User belongs to one Company, and each Company has many bank Accounts.

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3+, MySQL (`arthajaya_db`)
- **Frontend:** Blade templates, Tailwind CSS, Alpine.js, Vite
- **Auth scaffolding:** Laravel Breeze (with custom `AuthController`)
- **Dev server:** `composer dev` runs `php artisan serve` + queue worker + pail logs + Vite concurrently
- **Asset pipeline:** Vite (`resources/css/app.css`, `resources/js/app.js`), build via `npm run build`

## Directory Structure

```
app/
  Http/
    Controllers/
      AuthController.php          # Custom login/register/logout (standalone auth pages)
      OnboardingController.php    # Multi-step onboarding wizard + success screen
      ProfileController.php       # User profile CRUD (Breeze-standard)
      Auth/                       # Breeze auth controllers (unused or alternate)
    Middleware/
      EnsureOnboardingComplete.php # Guards routes until user completes onboarding
    Requests/
      ProfileUpdateRequest.php
      Auth/LoginRequest.php
  Models/
    User.php                      # belongsTo Company; uses Fillable/Hidden attributes
    Company.php                   # hasMany Accounts, hasMany Users
    Account.php                   # bank_name, account_name, account_number, initial_balance
  Providers/
    AppServiceProvider.php
  View/Components/
    AppLayout.php                 # Renders layouts.app (used by profile pages)
    GuestLayout.php

resources/views/
  welcome.blade.php               # Public landing page (standalone, no layout)
  onboarding.blade.php            # Onboarding wizard (standalone, full-page)
  dashboard.blade.php             # Main dashboard (standalone, full-page)
  auth/                           # Auth pages (standalone, not using layouts/auth for all)
  layouts/
    app.blade.php                 # Authenticated app shell with sidebar + settings widget
    navigation.blade.php          # Sidebar component (included in layouts.app)
    auth.blade.php                # Breeze auth layout (used by some auth views)
    guest.blade.php               # Guest layout
  components/                     # Shared Blade components (buttons, inputs, modals, etc.)
  profile/                        # Profile management views

routes/
  web.php                         # Main routes: home, auth, onboarding, dashboard
  auth.php                        # Breeze auth routes (password reset, email verify, etc.)

bootstrap/app.php                 # Registers middleware alias: 'onboarding.complete'
```

## Database Schema

| Table | Key Columns |
|---|---|
| `users` | id, name, email, password, `company_id` (FK, nullable), phone, role |
| `companies` | id, name, industry, business_size, country, city, address, logo, currency (default IDR), timezone, date_format, report_language, fiscal_start_month, fiscal_year |
| `accounts` | id, `company_id` (FK, cascade), bank_name, account_name, account_number, initial_balance (decimal 15,2) |

Relationships: User → belongsTo Company → hasMany Accounts.

## Routing & Middleware

- `guest` middleware: login, register pages
- `auth` middleware: onboarding routes, logout, dashboard, profile
- `onboarding.complete` middleware: applied to dashboard and future protected routes — redirects to onboarding if `user.company_id` is null
- Register new middleware aliases in `bootstrap/app.php`

## Onboarding Flow

1. User registers → redirected to `/dashboard`
2. `EnsureOnboardingComplete` middleware checks `company_id`; if null, redirects to `/onboarding`
3. Onboarding wizard (multi-step form) creates Company + Account, sets `company_id` on User
4. Success screen shown via `session('completed')`; user clicks through to dashboard

**Important:** After onboarding `store()`, the redirect passes `session('completed')`. The success screen section in `onboarding.blade.php` depends on this session flag and the `$company` variable being loaded with eager-loaded `accounts`.

## Design System

- **Dark-first** UI with CSS custom properties (`--bg`, `--surface`, `--emerald`, etc.)
- **Theme switcher:** dark/light via `localStorage('aj-theme')`, applied as `data-theme` on `<html>`
- **Accent colors:** emerald (default), blue, purple, orange, pink — via `localStorage('aj-accent')`
- **Fonts:** Space Grotesk (headings), Inter (body), IBM Plex Mono (mono)
- **Language toggle:** Indonesian (default) / English — `data-i18n-*` attributes, client-side
- Settings widget (gear FAB) is present on `layouts/app.blade.php` and standalone pages

## Coding Conventions

- **Language:** UI text is in **Indonesian** (Bahasa Indonesia). Code comments may mix Indonesian and English.
- **Blade templates:** Most major pages (welcome, onboarding, dashboard) are **standalone** — they do NOT use `x-app-layout` or `layouts/app.blade.php`. They duplicate the full HTML structure (head, styles, scripts). Profile-related views use the `AppLayout` component.
- **CSS:** Heavy use of inline `<style>` blocks in Blade templates alongside Tailwind. The design system uses CSS custom properties for theming. Tailwind is available via `app.css` but most styling is hand-written CSS.
- **JS:** Alpine.js is loaded globally. Page-specific JS is inlined in Blade templates or in `resources/js/app.js`.
- **Models:** Use Laravel 11+ attribute-based `#[Fillable]` and `#[Hidden]` on User model. Company and Account use traditional `$fillable` arrays.
- **Null safety:** Use PHP 8.1 null-safe operator (`?->`) when accessing potentially null relationships in Blade (e.g., `$company?->accounts?->first()?->initial_balance ?? 0`). The `??` operator alone does not protect against calling methods on null objects.

## Common Pitfalls

- `$company` can be null in the onboarding success screen if the user has no company. Always use `?->` for relationship chains.
- `$company->accounts->first()` returns null when the accounts collection is empty — guard with `?->` before accessing properties on the result.
- Duplicate auth systems exist: `AuthController` (custom, used by `routes/web.php`) and `Auth/AuthenticatedSessionController` (Breeze, used by `routes/auth.php`). The custom `AuthController` is the active one for login/register.
- Several sidebar links (Faktur, Klien, Transaksi, Rekonsiliasi, Laporan) are placeholders (`href="#"`) — not yet implemented.
- Dashboard is a standalone Blade file with its own full HTML/CSS/JS — not using the app layout.

## Running the Project

```bash
composer setup        # Install deps, generate key, migrate, build assets
composer dev          # Run server + queue + pail + vite concurrently
php artisan serve     # Just the HTTP server on localhost:8000
npm run dev           # Vite dev server with HMR
npm run build         # Production asset build
php artisan migrate   # Run pending migrations
```

Database: MySQL on `127.0.0.1:3306`, database `arthajaya_db`, user `root`, no password (Laragon default).

## Future Modules (Planned)

Based on sidebar navigation, these modules are planned but not yet built:
- **Faktur** (Invoices)
- **Klien** (Clients)
- **Transaksi** (Transactions)
- **Rekonsiliasi Bank** (Bank Reconciliation)
- **Laporan** (Financial Reports)
