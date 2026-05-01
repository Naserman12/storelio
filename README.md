
---

# 🏪 Storelio - SaaS Multi-Vendor E-commerce Platform

Storelio is a **multi-tenant SaaS e-commerce platform** built with Laravel, allowing users to create and manage their own online stores with full isolation, scalability, and customization.

It provides a complete backend API for building modern e-commerce applications (Web / Mobile / SPA).

---

# 🚀 Features

## 👤 Authentication & Roles

* Secure API authentication using **Laravel Sanctum**
* Role-based access control:

  * `super_admin`
  * `store_owner`
  * `employee`
  * `customer`

---

## 🏪 Multi-Tenant Stores

* Each user (store owner) can create a dedicated store
* Full data isolation per store
* Store ownership via `owner_id`
* Ready for SaaS scaling

---

## 📦 Product Management

* Create, update, delete products
* Auto-assign products to current store
* Support for:

  * Price
  * Quantity
  * Description
  * Images
* Extensible for variants & discounts

---

## 🗂️ Categories System

* Store-based categories
* Assign products to categories
* Filter products by category
* Organized catalog structure

---

## 🛒 Cart System

* User-based shopping cart
* Add / update / remove items
* Quantity management
* Automatic cart creation per store

---

## 🧾 Orders System

* Convert cart into orders (Checkout)
* Store order items snapshot
* Order status tracking:

  * pending
  * paid
  * shipped
  * completed
  * cancelled
* Automatic cart clearing after order creation

---

## 💳 Payments System

* Multiple payment methods:

  * Cash on Delivery (COD)
  * Bank Transfer
  * Card (ready for gateway integration)
* Payment tracking per order
* Transaction ID support
* Automatic order status update

---

## ⚙️ Settings System

* Flexible key-value settings per store
* Fully dynamic configuration
* Examples:

  * Store name
  * Currency
  * Tax settings
  * Theme configuration

---

## 🎨 Theme System

* Multiple store themes support:

  * Default
  * Modern
  * Dark
  * Minimal
* Theme stored in settings (no code changes required)
* Fully dynamic UI customization ready

---

## 📊 Dashboard API

* Store analytics endpoints:

  * Total products
  * Total orders
  * Total sales
  * Customers count
* Latest orders overview
* Ready for frontend dashboards (Vue / React)

---

# 🏗️ Tech Stack

* **Backend:** Laravel 10+
* **Auth:** Laravel Sanctum
* **Database:** MySQL
* **Architecture:** RESTful API
* **Design Pattern:** Multi-Tenant SaaS Architecture
* **Scope:** Store-based data isolation

---

# 🧠 Architecture Overview

* Multi-Tenant SaaS design
* Store isolation using `store_id`
* Role-based access control
* Settings-driven configuration
* Modular API structure

---

# 📂 Project Modules

* Authentication
* Stores Management
* Products
* Categories
* Cart
* Orders
* Payments
* Settings
* Themes
* Dashboard Analytics

---

# 🚀 Getting Started

### 1. Clone repository

```bash
git clone https://github.com/your-username/storelio.git
cd storelio
```

---

### 2. Install dependencies

```bash
composer install
```

---

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

---

### 4. Run migrations

```bash
php artisan migrate
```

---

### 5. Start server

```bash
php artisan serve
```

---

# 🔐 API Authentication

Use Laravel Sanctum:

```
Authorization: Bearer YOUR_TOKEN
```

---

# 📊 Example API Endpoints

## Auth

```
POST /api/register
POST /api/login
POST /api/logout
```

## Products

```
GET    /api/products
POST   /api/products
PUT    /api/products/{id}
DELETE /api/products/{id}
```

## Orders

```
POST /api/orders
GET  /api/orders
```

## Cart

```
POST /api/cart/add
GET  /api/cart
```

---

# 🎯 Project Goal

Storelio aims to be a **scalable SaaS platform for e-commerce**, similar to Shopify, enabling users to:

* Launch online stores quickly
* Manage products and orders easily
* Customize store appearance
* Scale without technical complexity

---

# 🔥 Future Improvements

* Stripe / PayPal integration
* Subscription billing system
* Advanced analytics dashboard
* Multi-store switching
* Mobile App API support
* Webhooks system
* Admin panel for SaaS owner

---

# 👨‍💻 Author

Developed as a full SaaS learning + production project using Laravel API architecture.

---

# ⭐ If you like this project

Give it a star ⭐ on GitHub and contribute to its growth.
---