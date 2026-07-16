# Architecture

## Overview
This project is a Laravel 13 application built on the Livewire starter stack.
It uses Fortify for authentication, Livewire/Flux for UI composition, and Vite
for frontend asset bundling.

## Core Layers
- `routes/` defines the page entry points and feature routes.
- `app/` contains application logic, including auth actions, models, and service providers.
- `resources/views/` contains Blade views, layouts, and reusable UI components.
- `database/` contains the schema migrations, factories, and seeders.
- `public/` serves compiled assets and the front controller.

## Request Flow
1. The browser hits a route in `routes/web.php` or `routes/settings.php`.
2. Laravel resolves the route to a Blade view or Livewire-driven page.
3. Authentication is handled by Fortify and the custom providers in `app/Providers`.
4. The view renders the layout and shared components from `resources/views`.
5. Vite delivers the built CSS and JavaScript assets.

## Auth And Settings
Authentication is centered around Fortify:
- `app/Providers/FortifyServiceProvider.php` wires up login, register, password reset, and confirm-password views.
- `app/Actions/Fortify/*` contains the create-user and reset-password behavior.
- `routes/settings.php` and the settings views provide profile, security, appearance, and account deletion flows.

## UI Structure
The app uses a layered Blade layout system:
- `resources/views/layouts/app.blade.php` is the authenticated shell.
- `resources/views/layouts/auth/*` contains auth-specific shells.
- `resources/views/components/*` provides shared widgets such as logos, headers, and menu elements.

## Notes
- The current codebase is more of a starter application than a domain-specific product.
- There is no game engine or simulation layer in the repository today.
- The `dashboard` page currently acts as a placeholder surface for future product content.
