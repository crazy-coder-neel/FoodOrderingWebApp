# 🍔 Fast Food Ordering WebApp

A dynamic **Fast Food Ordering System** built with **PHP and MySQL**, designed to offer users an intuitive interface for browsing menu items, adding food to a cart, selecting a payment option (Cash/Online), and receiving an automatically generated invoice. The application uses **PHP sessions** to manage cart functionality and **PDF generation** (e.g., using `fpdf`) for invoice creation.

---

## 🚀 Features

🛒 Add/remove items from cart (session-based)

👤 Session-managed user experience

📃 Order placement and order history

💳 Payment by Cash or Online

🧾 Auto-generated invoice (PDF using FPDF)

📂 Admin-side (optional): View and manage orders

🗃️ Relational database design (MySQL)

---

## 🧰 Tech Stack

| Layer     | Technology                        |
| --------- | --------------------------------- |
| Frontend  | HTML, CSS, JavaScript             |
| Backend   | PHP 5                             |
| Database  | MySQL                             |
| Server    | Apache (XAMPP)                    |
| Libraries | `fpdf` for PDF invoice generation |

---

# ⚙️ Installation & Setup

### ✅ Requirements

- PHP 5.x or below
- MySQL Server
- Apache Server (XAMPP / WAMP / LAMP)
- Web browser

### 🛠️ Installation Steps

1. **Clone the Repository**
   git clone https://github.com/crazy-coder-neel/FoodOrderingWebApp

📌 Import **database_setup.sql** SQL file into phpMyAdmin or using a MySQL CLI tool.

**Configure Database:**

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fastfood_db';

$conn = new mysqli($host, $username, $password, $database);

**Start Apache and MySQL via XAMPP/WAMP/LAMP.**

**Run the App in Browser**

http://localhost/FastFood/index.php.
