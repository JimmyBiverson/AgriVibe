# Agrivibe

Agrivibe is a production-ready agribusiness platform built with Laravel 13, Livewire, Blade, Tailwind CSS, and Filament v5. It provides public knowledge, farmer tools, farm/livestock management, veterinary references, community, marketplace, training, and an admin back-office — all themed in a clean green UI.

## System Overview

- Public portal: Home, About, Contact, FAQs, Knowledge base (articles by category), Search
- Section hub: Marketplace, Find a Vet, Training, Community, Market Prices
- Auth: Registration, login, email verification, password reset, OTP verification
- User dashboard: Authenticated overview
- Admin (Filament): Core resources

## Tech Stack

- Backend: PHP 8.4, Laravel 13.35, Filament 5.10, Livewire 4.4, Sanctum, Spatie Permission, MediaLibrary, Activitylog
- Frontend: Vite, Tailwind CSS, Alpine.js
- Exports/PDF: Maatwebsite Excel, DomPDF
- Database: MySQL

## Quick Start

1. Install deps: composer install; npm install
2. Configure: cp .env.example .env; php artisan key:generate
3. DB: create agrivibe; php artisan migrate:fresh --seed
4. Assets + serve: npm run build; php artisan serve

Admin: /admin | Default currency UGX, locale en, timezone Africa/Kampala
