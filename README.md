# 🍽️ La Maison Restaurant Management System

[![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://mysql.com)
A comprehensive restaurant management system built with Laravel 11, featuring a public website, role-based staff dashboard, and AI-powered mobile companion app.

---

## 📋 Table of Contents

- [Features](#-features)
- [System Requirements](#-system-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [API Documentation](#-api-documentation)
- [Testing](#-testing)
- [Troubleshooting](#-troubleshooting)
---

## ✨ Features

### 🌐 Public Website
- Browse menu with categories
- Make table reservations
- View private dining options
- Contact and about pages
- No login required

### 👔 Staff Dashboard (Role-Based Access)

#### Owner Access
- User management (create/edit/delete staff)
- Table management
- Booking confirmation/cancellation
- Customer CRM (history, notes, VIP status)
- Discount code management
- Activity logs (audit trail)

#### Supervisor Access
- Menu category management
- Menu item CRUD (create, read, update, delete)
- Inventory tracking
- Stock transaction recording (restock, usage, waste)

#### Waiter Access
- Order creation and management
- Payment processing (cash, card, mobile)
- Active table viewing
- Order status updates

### 🤖 AI Mobile App Integration
- RESTful API endpoint for Flutter mobile app
- Natural language meal filtering
- Ollama AI integration for intent extraction
- Filters by allergies, protein, calories

---

## 💻 System Requirements

- **PHP**: 8.2 or higher
- **Composer**: 2.x
- **MySQL**: 8.0 or higher
- **Node.js**: 18.x or higher (for asset compilation)
- **Apache/Nginx**: Web server
- **Ollama**: (Optional) For AI chatbot features

**Recommended Development Environment:**
- Laragon (Windows)
- Laravel Valet (macOS)
- Docker with Laravel Sail (Cross-platform)

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/la-maison-restaurant.git
cd la-maison-restaurant
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=la_maison
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations & Seeders

```bash
# Create database tables
php artisan migrate

# Seed with sample data
php artisan db:seed
```

### 6. (Optional) Install Ollama for AI Features

**Windows:**
```bash
# Download from https://ollama.com/download/windows
# Install and run:
ollama pull llama3.2:3b
```

**macOS:**
```bash
brew install ollama
ollama serve
ollama pull llama3.2:3b
```

**Linux:**
```bash
curl -fsSL https://ollama.com/install.sh | sh
ollama serve
ollama pull llama3.2:3b
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## ⚙️ Configuration

### CORS Setup (For Mobile App)

The system includes CORS configuration for API access:

**File:** `config/cors.php`

```php
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'],  // Change in production!
```

**Production:** Update `allowed_origins` to specific domains.

### AI Service Configuration

**File:** `app/Services/MealAiService.php`

```php
private const OLLAMA_URL = 'http://localhost:11434/api/generate';
private const MODEL = 'llama3.2:3b';
```

---

## 📖 Usage

### Default Login Credentials

After running `php artisan db:seed`:

| Role | Email | Password |
|------|-------|----------|
| Owner | owner@lamaison.com | password |
| Supervisor | supervisor@lamaison.com | password |
| Waiter | waiter@lamaison.com | password |

### Accessing Dashboards

- **Owner Dashboard:** `/admin`
- **Supervisor Dashboard:** `/supervisor`
- **Waiter Dashboard:** `/waiter`

### Public Pages

- **Home:** `/`
- **Menu:** `/menu`
- **Booking:** `/booking`
- **Private Dining:** `/private-dining`
- **About:** `/about`

---

## 📁 Project Structure

```
project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Owner controllers
│   │   │   ├── Supervisor/      # Supervisor controllers
│   │   │   ├── Waiter/          # Waiter controllers
│   │   │   ├── Website/         # Public website controllers
│   │   │   └── Api/             # API controllers (mobile app)
│   │   └── Middleware/
│   │       └── RoleMiddleware.php  # Role-based access control
│   ├── Models/                  # Eloquent models (14 models)
│   └── Services/
│       └── MealAiService.php    # Ollama AI integration
│
├── database/
│   ├── migrations/              # 16 database tables
│   └── seeders/
│
├── resources/views/
│   ├── layouts/
│   │   ├── dashboard.blade.php  # Staff dashboard layout
│   │   └── website.blade.php    # Public website layout
│   ├── dashboard/
│   │   ├── admin/               # Owner views
│   │   ├── supervisor/          # Supervisor views
│   │   └── waiter/              # Waiter views
│   └── website/                 # Public pages
│
├── routes/
│   ├── web.php                  # Website & dashboard routes
│   └── api.php                  # Mobile app API routes
│
└── config/
    └── cors.php                 # CORS configuration
```

---

## 🔌 API Documentation

### Chat Endpoint (AI Meal Filtering)

**Endpoint:** `POST /api/chat`

**Request:**
```json
{
  "message": "I want high protein meals with no nuts"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Found 3 meals (25g+ protein, avoiding nuts):",
  "meals": [
    {
      "id": 1,
      "name": "Grilled Chicken Breast",
      "description": "Tender grilled chicken",
      "price": 18.99,
      "protein": 30,
      "calories": 450,
      "image_url": null,
      "category": "Mains"
    }
  ],
  "filters": {
    "avoid": "nuts",
    "min_protein": 25,
    "max_calories": null
  }
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Sorry, something went wrong."
}
```

---

## 🧪 Testing

### Run Tests

```bash
php artisan test
```

### Test API Endpoint

```bash
curl -X POST http://localhost:8000/api/chat \
  -H "Content-Type: application/json" \
  -d '{"message": "high protein meals"}'
```

### Test Ollama Directly

```bash
curl http://localhost:11434/api/generate \
  -d '{
    "model": "llama3.2:3b",
    "prompt": "Convert to JSON: high protein",
    "stream": false
  }'
```

---

## 🔧 Troubleshooting

### Issue: "Access Denied" on Dashboard

**Solution:** Check user role in database:
```sql
SELECT email, role FROM users;
```

### Issue: "Cannot connect to API" (Mobile App)

**Solution:** 
1. Verify Laravel is running: `php artisan serve`
2. Check CORS is enabled: `config/cors.php`
3. Use `10.0.2.2:8000` for Android emulator (not `localhost`)

### Issue: AI Returns Empty/Wrong Results

**Solution:**
1. Check Ollama is running: `ollama list`
2. Upgrade model: `ollama pull llama3.2:3b`
3. Check logs: `tail -f storage/logs/laravel.log`
4. Clear cache: `php artisan cache:clear`

### Issue: Database Migration Errors

**Solution:**
```bash
php artisan migrate:fresh --seed
```

### Issue: Permission Errors

**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🗄️ Database Schema

### Main Tables

| Table | Purpose |
|-------|---------|
| users | Staff accounts with roles |
| tables | Restaurant tables |
| bookings | Customer reservations |
| customers | CRM database |
| menu_categories | Menu organization |
| menu_items | Dishes with nutrition info |
| orders | Customer orders |
| order_items | Items within orders |
| payments | Payment records |
| discounts | Promotional codes |
| inventory_items | Ingredient stock |
| inventory_transactions | Stock changes |
| activity_logs | Audit trail |

### Relationships

- **Table** `hasMany` **Orders**
- **Order** `belongsTo` **Table**
- **Order** `hasMany` **OrderItems**
- **Order** `belongsToMany` **Discounts**
- **MenuItem** `belongsToMany` **InventoryItems**

---

## 🛡️ Security Features

- ✅ CSRF protection on all forms
- ✅ Role-based access control (middleware)
- ✅ Password hashing (bcrypt)
- ✅ SQL injection protection (Eloquent ORM)
- ✅ Activity logging
- ✅ Input validation on all forms
- ✅ Mass assignment protection

---

## 📝 Development Notes

### Adding New Staff Member

```php
use App\Models\User;

User::create([
    'name' => 'John Doe',
    'email' => 'john@lamaison.com',
    'password' => bcrypt('password'),
    'role' => 'waiter', // owner, supervisor, or waiter
]);
```

### Creating New Menu Item

```php
use App\Models\MenuItem;

MenuItem::create([
    'name' => 'Caesar Salad',
    'description' => 'Fresh romaine lettuce',
    'price' => 12.99,
    'protein' => 8,
    'calories' => 350,
    'category_id' => 1,
    'is_available' => true,
]);
```

### Recording Stock Transaction

```php
use App\Models\InventoryTransaction;

InventoryTransaction::create([
    'inventory_item_id' => 1,
    'type' => 'restock', // restock, usage, waste
    'quantity' => 50,
    'notes' => 'Weekly restock',
    'user_id' => auth()->id(),
]);
```

---

## 🚀 Deployment

### Production Checklist

```bash
# 1. Set environment to production
APP_ENV=production
APP_DEBUG=false

# 2. Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Run optimizations
composer install --optimize-autoloader --no-dev

# 4. Set permissions
chmod -R 755 storage bootstrap/cache

# 5. Update CORS for production
# Edit config/cors.php - set specific allowed_origins

# 6. Set up SSL/HTTPS

# 7. Configure database backups

# 8. Set up monitoring (logs, errors)
```
---

**Built with ❤️ using Laravel 11**
