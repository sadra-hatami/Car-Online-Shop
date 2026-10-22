<div align="center">

# Online Car Store
# 🚗

### A PHP site for car ads, categories, and users

Browse car listings, open a listing, and manage ads, categories, users, and messages from the same desk.

<br>

# 👨‍💻 **Sadra Hatami**

### *Developer • Software Engineer • Creator*

<br>

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![Cars](https://img.shields.io/badge/Domain-Car%20Ads-C0392B?style=for-the-badge)](#-key-features)
[![Listings](https://img.shields.io/badge/Feature-Listings-E67E22?style=for-the-badge)](#-key-features)
[![Users](https://img.shields.io/badge/Feature-Users-2980B9?style=for-the-badge)](#-key-features)
[![Persian](https://img.shields.io/badge/Catalog-Persian-success?style=for-the-badge)](https://en.wikipedia.org/wiki/Persian_language)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](https://opensource.org/license/mit)
[![Open Source](https://img.shields.io/badge/Open_Source-Project-black?style=for-the-badge&logo=github)](https://opensource.org/)

<br>

[🌐 GitHub Profile](https://github.com/sadra-hatami)
•
[📧 Email](mailto:sadra.hatami.1732@gmail.com)

</div>

---

# 📑 Table of Contents

- [About](#-about)
- [Why This Project?](#-why-this-project)
- [Key Features](#-key-features)
- [Pages](#-pages)
- [Project Structure](#-project-structure)
- [Technologies](#️-technologies)
- [Installation](#-installation)
- [Configuration](#️-configuration)
- [Usage](#️-usage)
- [Related Projects](#-related-projects)
- [Contact](#-contact)
- [License](#-license)
- [Support](#-support)

---

# 📖 About

**Online Car Store** is a PHP site for car listings.

A visitor opens the home page, browses ads, and reads a listing. The desk behind it covers categories, subcategories, users, comments, and messages. The SQL file builds the tables, and car images sit in the `images` folder.

> **Tagline:** *A PHP car-ads site with listings, categories, users, and a MySQL script.*

---

# 🚀 Why This Project?

A car board is more than a picture and a price.

This site keeps the pieces together:

- Ads with model, mileage, condition, price, and color
- Categories and subcategories
- User accounts and comments
- A message list for the desk

The product store in [Online Shop](https://github.com/sadra-hatami/Online-Shop) is a separate project.

---

# ✨ Key Features

- 🚗 Car listings
- 🔎 Listing detail
- 🗂️ Categories and subcategories
- 👤 User list, detail, and update
- 💬 Comments
- ✉️ Messages
- 📝 Register and logout
- 💾 MySQL script and local images

---

# 📄 Pages

| Page | Role |
|---|---|
| `index.php` | Home |
| `ads.php` / `ads_list.php` / `ads_detail.php` | Listings |
| `ads_update.php` | Edit a listing |
| `cat.php` / `cat_list.php` / `cat_update.php` | Categories |
| `subcat.php` / `sub_list.php` / `sub_update.php` | Subcategories |
| `register.php` | Register |
| `user_list.php` / `user_detail.php` / `user_update.php` | Users |
| `user_comment.php` | Comments |
| `msg_list.php` / `msg_detail.php` | Messages |

---

# 📁 Project Structure

```text
Online-Car-Store/
├── index.php
├── ads.php
├── cat.php
├── register.php
├── db.sql
├── Connections/
├── images/
├── styles/
└── README.md
```

`Connections/connect.php` holds the database settings. `styles/main.css` is the stylesheet.

---

# 🛠️ Technologies

- PHP
- MySQL
- HTML and CSS
- UTF-8 catalog text

---

# 🚀 Installation

```bash
git clone https://github.com/sadra-hatami/Online-Car-Store.git
cd Online-Car-Store
```

1. Place the folder under a PHP server, such as XAMPP `htdocs`.
2. Import `db.sql` in MySQL.
3. Open `index.php`.

---

# ⚙️ Configuration

Database settings are in `Connections/connect.php`:

```text
host       localhost
user       root
password
database   car
```

The SQL file creates the `cars` database. If the names differ, make `connect.php` and the imported database match before a public run.

---

# ▶️ Usage

1. Import the SQL file.
2. Open the home page and browse a listing.
3. Use the category, user, and message pages to manage the desk.

---

# 🔗 Related Projects

| Repository | Role |
|---|---|
| **[Online Car Store](https://github.com/sadra-hatami/Online-Car-Store)** | Car listings (this repo) |
| **[Online Shop](https://github.com/sadra-hatami/Online-Shop)** | Product storefront |
| **[Electronics Business Website](https://github.com/sadra-hatami/Electronics-Business-Website)** | Electronics storefront |

---

# 📬 Contact

**Developer:**

### Sadra Hatami

📧 [Email](mailto:sadra.hatami.1732@gmail.com)

🌐 [GitHub](https://github.com/sadra-hatami)

---

# 📄 License

This project is licensed under the **MIT License**.

---

# ⭐ Support

If this car site is useful as a portfolio sample, please consider giving it a ⭐ on GitHub.

---

<div align="center">

## Designed & Developed with ❤️ for the developer community of Iran and the world by **Sadra Hatami**

</div>
