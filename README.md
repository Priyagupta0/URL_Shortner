# 🔗 PHP URL Shortener

A lightweight and simple URL shortener built with **PHP** and **MySQL**.
It allows users to convert long URLs into short, shareable links — ideal for learning backend logic, form handling, and database interaction.

---

## 🚀 Features

* Generate short URLs from long links
* Redirect users from short URL to original destination
* Prevents form resubmission on page refresh
* Keeps all records in the database (but hides old ones from UI)
* Clean and responsive layout (customizable via `style.css`)

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone <LINK>
cd url-shortener
```

### 2. Create the Database

1. Log in to MySQL:

   ```bash
   mysql -u root -p
   ```
2. Create a new database:

   ```sql
   CREATE DATABASE url_shortener;
   ```
3. Switch to the database:

   ```sql
   USE url_shortener;
   ```
4. Create the `urls` table:

   ```sql
   CREATE TABLE urls (
       id INT AUTO_INCREMENT PRIMARY KEY,
       long_url TEXT NOT NULL,
       short_code VARCHAR(10) NOT NULL UNIQUE,
   );
   ```

### 3. Configure Database Connection

Update your `config.php` file with your database credentials:

```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "url_shortener";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### 4. Run the Project

* Move the project folder into your server directory (`htdocs` for XAMPP or `www` for WAMP).
* Start **Apache** and **MySQL** in your local server environment.
* Open the project in your browser:

  ```
  http://localhost/url-shortener/
  ```

---

## 📂 Project Structure

```
url-shortener/
│── index.php        # Main form and display page
│── config.php       # Database connection settings
│── style.css        # Basic styling
└── README.md        # Project documentation
```

---

## 🎯 Usage

1. Enter a long URL in the input field and click **Shorten**.
2. A new short link will be generated and displayed.
3. Use the short link in your browser to get redirected to the original URL.

---

## 📜 License

This project is licensed under the **MIT License**.
You are free to use, modify, and distribute it for personal or commercial projects.

---
