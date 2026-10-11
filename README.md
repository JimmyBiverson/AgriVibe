# AgriVibe — Smart Agribusiness Platform

AgriVibe is a production-ready, 3D-enhanced agribusiness and veterinary management platform built with Laravel 13, Livewire, Blade, Tailwind CSS v4, and Filament v5. It empowers smallholder and commercial farmers with real-time telemetry, livestock and crop management, feed calculation, certified veterinary telemedicine, and marketplace trading.

---

## 🌟 Key Features

### 1. 3D Welcoming Agricultural Portal
- **Immersive 3D Hero Interface**: Interactive farm hub card featuring real-time livestock telemetry (Friesian dairy yield, Broiler batch livability, Aquaculture dissolved oxygen, Biosecurity status).
- **Live Market Price Ticker**: Real-time commodity tracking across major East African market hubs (Kampala, Jinja, Mbarara, Gulu, Mbale) with live trend indicators.
- **Interactive 3D Sector Explorer**: Dedicated modules for Livestock, Poultry, Aquaculture, Cash & Feed Crops, Veterinary Telemedicine, and Agribusiness Finance.
- **In-Browser 3D Profitability & Feed Calculator**: Estimate feed requirements (50kg bags), break-even costs, gross revenue, and projected net profits for Broilers, Layers, and Tilapia ponds.
- **Universal Inclusion (SMS & USSD)**: Integrated simulation for offline farmers using basic 2G feature phones (*284*40# USSD and SMS commands).

### 2. Multi-Role User Workspaces
- **Farmer**: Herd/flock batch registers, milk & egg logs, vaccination calendar with mandatory medicine withdrawal warnings, profit calculations.
- **Veterinary Doctor**: Clinical appointments, telemedicine triage, digital prescription creation.
- **Buyer**: Wholesale produce ordering, sourcing requests, live price trends.
- **Supplier**: Agricultural inputs, feed inventory, stock reorders.
- **Trainer**: Agrivibe Academy agricultural courses and certifications.

### 3. Back-Office Admin Intelligence (Filament v5)
- Glowing gradient line charts for platform engagement.
- 3D pie/donut breakdown of enterprise distribution.
- Real-time system performance monitors (SMS Gateway, Queues, Database size, Active sessions).

---

## 🛠️ Tech Stack

- **Backend**: PHP 8.4, Laravel 13.35, Filament 5.10, Livewire 4.4, Sanctum, Spatie Permission, MediaLibrary, Activitylog
- **Frontend**: Vite, Tailwind CSS v4, Alpine.js, Chart.js
- **Exports/Reporting**: Maatwebsite Excel, DomPDF
- **Database**: MySQL

---

## 🚀 Quick Start

1. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

2. **Environment & Database**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

3. **Compile Assets & Run**:
   ```bash
   npm run build
   php artisan serve --port=8089
   ```

4. **Demo Credentials**:
   - **Admin Panel**: `http://127.0.0.1:8089/admin` (`admin@agrivibe.test` / `password`)
   - **Farmer Workspace**: `farmer@agrivibe.test` / `password`
   - **Veterinary Doctor**: `vet@agrivibe.test` / `password`
   - **Marketplace Buyer**: `buyer@agrivibe.test` / `password`
   - **Input Supplier**: `supplier@agrivibe.test` / `password`
   - **Academy Trainer**: `trainer@agrivibe.test` / `password`

---

*Default currency: UGX | Timezone: Africa/Kampala*

