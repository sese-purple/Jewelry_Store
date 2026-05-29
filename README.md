<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
</p>

<p align="center">
  <img src="https://img.shields.io/github/license/sese-purple/Jewelry_Store" alt="License">
  <img src="https://img.shields.io/github/last-commit/sese-purple/Jewelry_Store" alt="Last Commit">
  <img src="https://img.shields.io/github/repo-size/sese-purple/Jewelry_Store" alt="Repo Size">
</p>

<h1 align="center">💍 Elegant Jewelry & Co</h1>
<h3 align="center">A full-featured luxury jewelry e-commerce platform built with Laravel</h3>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#screenshots">Screenshots</a> •
  <a href="#getting-started">Getting Started</a> •
  <a href="#project-structure">Project Structure</a> •
  <a href="#routes">Routes</a> •
  <a href="#database">Database</a>
</p>

---

## ✨ Features

### 👤 Authentication
- Custom registration & login (no Breeze/Jetstream)
- Password confirmation with client-side validation
- Password visibility toggle
- Remember-me functionality

### 📦 Product Management
- Full CRUD with jewelry-specific fields (material, brand, size, color, weight, gender, SKU)
- Image upload with live preview
- Featured & active product toggles
- Category-based filtering
- Search functionality
- Stock quantity tracking (buy/sell adjustments)

### 🗂️ Category Management
- Full CRUD with automatic slug generation
- Sort ordering & active/inactive toggling
- Category image upload
- Product counts per category

### 🛒 Shopping Cart
- Add, update quantity, remove, clear all
- Stock validation before adding
- Unique product-per-user constraint
- Real-time cart count via AJAX
- Price calculations with totals

### ❤️ Wishlist
- Add/remove products with AJAX toggle
- Clear entire wishlist
- Per-user wishlist management

### 📋 Order Processing
- Multi-step checkout flow (shipping info + payment method)
- Three payment methods: PayPal, Stripe, Cash on Delivery
- Simulated payment processing
- DB-transactional order creation
- Automatic stock decrement on order
- Detailed order history with pagination
- Order status tracking (pending, paid, processing, shipped, delivered, cancelled)
- Order confirmation page

### 🎨 Frontend
- Luxury Tiffany-inspired color palette (Tiffany blue, gold, deep blue)
- Playfair Display + Lato typography
- Font Awesome 6 icons
- Fully responsive design (desktop, tablet, mobile)
- Smooth fade-in animations & hover effects
- Custom checkbox, password toggle, and UI components

---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **Laravel 12** | PHP web framework |
| **PHP 8.2+** | Backend language |
| **MySQL** | Database |
| **Tailwind CSS 4** | Utility-first CSS (via Vite) |
| **Vite** | Frontend build tool |
| **Blade** | Templating engine |
| **Font Awesome 6** | Icons |
| **Google Fonts** | Playfair Display + Lato |

---

## 📱 Screenshots

> *Coming soon*

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer 2.x
- MySQL
- Node.js & npm (for Vite/Tailwind)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/sese-purple/Jewelry_Store.git
cd Jewelry_Store

# 2. Install PHP dependencies
composer install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=my_shop_db
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. (Optional) Seed the database
php artisan db:seed

# 7. Install & build frontend assets
npm install
npm run build

# 8. Start the development server
php artisan serve
```

Visit **http://127.0.0.1:8000** in your browser.

### Development

```bash
# Start Laravel + Vite hot-reload
composer dev

# Or separately:
php artisan serve    # Laravel server
npm run dev          # Vite hot-reload
```

---

## 📂 Project Structure

```
Jewelry_Store/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CartController.php       # Cart CRUD + count
│   │   │   ├── CategoryController.php   # Category CRUD
│   │   │   ├── MainController.php       # Homepage
│   │   │   ├── OrderController.php      # Order checkout & history
│   │   │   ├── ProductController.php    # Product CRUD + filters
│   │   │   ├── UserController.php       # Auth (login/register)
│   │   │   └── WishlistController.php   # Wishlist CRUD + toggle
│   │   └── Policies/
│   │       ├── CartPolicy.php
│   │       └── OrderPolicy.php
│   └── Models/
│       ├── Cart.php
│       ├── Category.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Product.php
│       ├── User.php
│       └── Wishlist.php
├── config/              # Application configuration
├── database/
│   ├── migrations/      # 10 migration files
│   └── seeders/         # Category seeders
├── public/
│   ├── css/style.css    # Main stylesheet (878 lines)
│   └── images/          # Product & category images
├── resources/
│   └── views/
│       ├── layout/main_page.blade.php
│       ├── welcome.blade.php
│       ├── login.blade.php
│       ├── registration.blade.php
│       ├── product/          # 4 views
│       ├── category/         # 3 views
│       ├── cart/index.blade.php
│       ├── wishlist/index.blade.php
│       └── orders/           # 4 views
├── routes/
│   ├── web.php           # All application routes
│   └── console.php
└── package.json          # Vite + Tailwind CSS
```

---

## 🛣️ Routes

All **32 routes** defined in `routes/web.php`:

| Method | URI | Name | Auth | Description |
|--------|-----|------|------|-------------|
| GET | `/` | `welcome` | — | Welcome/landing page |
| GET | `/home_page` | `homepage` | ✅ | User homepage |
| **Products** |
| GET | `/all_products` | `all_products` | — | All products grid |
| GET | `/product_for` | `product_form` | ✅ | Add product form |
| POST | `/inka` | `reister` | ✅ | Store new product |
| GET | `/edit_product/{id}` | `edit_product` | ✅ | Edit product form |
| POST | `/update_product/{id}` | `update_product` | ✅ | Update product |
| GET | `/delete_product/{product_id}` | `delete_product` | ✅ | Delete product |
| GET | `/products/category/{category_id}` | `products_by_category` | — | Filter by category |
| POST | `/sell_product/{id}` | `sell_product` | ✅ | Decrement stock |
| POST | `/purchase_product/{id}` | `purchase_product` | ✅ | Increment stock |
| **Auth** |
| GET | `/registration_form` | `registration_form` | — | Register form |
| POST | `/store_user` | `store_user` | — | Register user |
| GET | `/login` | `login` | — | Login form |
| POST | `/login_user` | `login_user` | — | Login user |
| GET | `/logout` | `logout` | ✅ | Logout |
| **Cart** |
| GET | `/cart` | `cart.index` | ✅ | View cart |
| POST | `/cart/add/{product}` | `cart.add` | ✅ | Add to cart |
| PATCH | `/cart/update/{cart}` | `cart.update` | ✅ | Update quantity |
| DELETE | `/cart/remove/{cart}` | `cart.remove` | ✅ | Remove item |
| DELETE | `/cart/clear` | `cart.clear` | ✅ | Clear cart |
| GET | `/cart/count` | `cart.count` | ✅ | Cart count (AJAX) |
| **Wishlist** |
| GET | `/wishlist` | `wishlist.index` | ✅ | View wishlist |
| POST | `/wishlist/add/{product}` | `wishlist.add` | ✅ | Add to wishlist |
| POST | `/wishlist/remove/{product}` | `wishlist.remove` | ✅ | Remove from wishlist |
| POST | `/wishlist/toggle/{product}` | `wishlist.toggle` | ✅ | Toggle (AJAX) |
| POST | `/wishlist/clear` | `wishlist.clear` | ✅ | Clear wishlist |
| **Orders** |
| GET | `/orders` | `orders.index` | ✅ | Order history |
| GET | `/orders/checkout` | `orders.checkout` | ✅ | Checkout form |
| POST | `/orders/checkout` | `orders.store` | ✅ | Place order |
| GET | `/orders/success/{order}` | `orders.success` | ✅ | Order confirmation |
| GET | `/orders/{order}` | `orders.show` | ✅ | Order details |

---

## 🗄️ Database

### Tables (10 migrations)

| Table | Description |
|-------|-------------|
| `users` | User accounts |
| `password_reset_tokens` | Password resets |
| `sessions` | User sessions |
| `cache` / `cache_locks` | Cache storage |
| `jobs` / `job_batches` / `failed_jobs` | Queue jobs |
| `categories` | Product categories (with slug, image, sort order) |
| `products` | Jewelry products (with material, brand, size, color, weight, gender, SKU) |
| `carts` | Shopping cart items (unique per user+product) |
| `wishlists` | Wishlist items |
| `orders` | Orders (with shipping/billing address as JSON, status, payment info) |
| `order_items` | Individual order line items (snapshot of product data at purchase) |

### Relationships

```
User ──hasMany──> Cart
User ──hasMany──> Order
User ──hasMany──> Wishlist
Category ──hasMany──> Product
Order ──hasMany──> OrderItem
OrderItem ──belongsTo──> Product
Cart ──belongsTo──> Product
Wishlist ──belongsTo──> Product
```

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
  Made with 💍 by <a href="https://github.com/sese-purple">sese-purple</a>
</p>
