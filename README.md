# 👕 FormAndFit — Design Showcase & Affiliate Storefront

A full-stack clothing design showcase platform where users can browse 
original apparel designs and get redirected to partner fulfilment 
platforms for purchase. Features a complete Admin Panel with analytics.

🔗 Live Demo: https://formandfit.infinityfree.me/

---

## ✨ Features

### 🛍️ User Side
- 🎨 Browse original clothing designs across 3 categories
  (T-Shirts, Hoodies, Accessories)
- 🔗 "Buy" button redirects to partner fulfilment platforms
- 📱 Responsive mobile navigation
- ✨ Vanta.js animated hero background
- 🖼️ Dynamic product pages served from MySQL database

### 🛡️ Admin Panel
- 📦 Upload and manage products with image handling
- 📋 Inventory management across 3 categories
- 📊 Product click tracking (Buy vs Share per product)
- 🌍 Visitor analytics by page and region
- 📅 7-day homepage visit counter
- ✏️ Edit and update existing products

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP |
| Database | MySQL |
| Frontend | HTML5, CSS3, Tailwind CSS |
| Interactivity | JavaScript |
| Animation | Vanta.js |
| Icons | Feather Icons |
| Server | Apache (XAMPP) |

---

## 🗄️ Database Structure

- products — apparel listings with images and category
- clicks — buy/share click tracking per product
- visits — visitor tracking by page, country, and region

---

## 🚀 How to Run Locally

1. Clone the repository
   git clone https://github.com/Godofthunder09/FormAndFit.git

2. Import the database
   - Open phpMyAdmin
   - Create a database named: formandfit
   - Import the .sql file from the /database/ folder

3. Configure database connection
   - Open: database/db_connection.php
   - Set your MySQL username and password

4. Start Apache & MySQL in XAMPP

5. Visit: http://localhost/formandfit/

---

## 📁 Project Structure

FormAndFit/
│
├── index.php                  # Landing page
├── tshirts.php                # T-Shirts category
├── hoodies.php                # Hoodies category
├── accessories.php            # Accessories category
├── admin/
│   └── admin_master.php       # Unified admin panel
├── database/
│   └── db_connection.php      # Database config
├── track_click.php            # Click tracking handler
└── README.md

---

## 🔐 Security Features

- Prepared statements to prevent SQL injection
- XSS prevention via htmlspecialchars()
- Session hardening and CSP headers
- File type validation on image uploads
- Transaction rollback on failed operations

---

## 📸 Screenshots

(Add screenshots here)

---

## 👨‍💻 Author

**Yash Patil**
📧 patil.yash.dev@gmail.com
🔗 linkedin.com/in/yash-patil-8168a9309

---

## 📄 License

MIT License — free to use and modify.
