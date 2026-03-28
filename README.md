# 🛡️ VoteXpress — Advanced Digital Electoral System

[![PHP Version](https://img.shields.io/badge/PHP-8.x-777bb4.svg?style=flat-square&logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Full%20Stack-00758f.svg?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-00f59b.svg?style=flat-square)](LICENSE)
[![Live Demo](https://img.shields.io/badge/Live-Demo-ff6b7a.svg?style=flat-square)](https://votexpress.wuaze.com/index.php)

> **Shaping Democracy with Technology.** A premium, secure, and transparent digital voting platform designed with a high-end "Cyber-Secure Dark" aesthetic.

---

## 🌐 Live Portal
Experience the platform in action at the Infinity-free server:
**[https://votexpress.wuaze.com/index.php](https://votexpress.wuaze.com/index.php)**

---

## ✨ Key Features

### 👤 Voter Gateway
- **Secure Entry**: Secure login via unique Voter IDs and encrypted passcodes.
- **Dynamic Ballot**: Adaptive voting interface that reflects the latest contested positions.
- **One-Vote Integrity**: Automated locks to prevent multiple voting attempts.
- **Vote Receipts**: Real-time confirmation of successfully cast ballots.

### 🔐 Administrative Command Center
- **Nominee Registry**: Full CRUD operations for candidates with photo asset management.
- **Voter Management**: Initialize and audit the roster of verified election participants.
- **Electoral Hierarchy**: Configure positions, vote limits, and priority sequencing.
- **Live Tally Engine**: Watch results stream in with real-time analytics and progress bars.
- **Ballot Flow Control**: Reorder the sequence of positions displayed to voters.

---

## 🎨 Design Philosophy
VoteXpress isn't just a voting script; it's a visual experience.
- **Rich Dark Canvas**: Deep anthracite and obsidian surfaces for reduced eye strain and high focus.
- **Cyber-Secure Accents**: Strategic use of **Cyber Red (#FF6B7A)** for critical actions and **Emerald Green (#00F59B)** for success states.
- **Glassmorphism**: Subtle blurs and translucent borders for a state-of-the-art feel.
- **Responsive Fluidity**: Optimized for everything from mobile devices to ultra-wide displays.

---

## 🛠️ Technology Stack
- **Backend Core**: PHP 8.x (Procedural/OOP architecture)
- **Database Architecture**: MySQL with relational integrity
- **Styling Engine**: Premium Vanilla CSS3 (Custom Variables / Flexbox / Grid)
- **Interaction Logic**: Modern JavaScript (Vanilla ES6+)
- **Cryptography**: Native BCrypt password hashing
- **Iconography**: Font Awesome 6.4 Professional

---

## ⚙️ Installation & Deployment

### Requirements
- **Server**: XAMPP, WAMP, or any Apache2 server
- **Database**: MySQL 5.7+ / MariaDB 10.4+
- **PHP**: 7.4 or higher (8.1 recommended)

### Setup Steps
1. **Clone the Repository**
   ```bash
   git clone [https://github.com/manaj/VoteXpress_PHP.git](https://github.com/Manajit6776/VoteXpress_PHP)
   ```

2. **Initialize Database**
   - Access `phpMyAdmin` or your SQL client.
   - Create a database named `votesystem`.
   - Import the `Votexpressdb.sql` file provided in the root directory.

3. **Configure Connection**
   - Edit `db_connect.php` with your local credentials:
   ```php
   $conn = new mysqli('localhost', 'root', '', 'votesystem');
   ```

4. **Launch Platform**
   - Move the directory to `htdocs` or your web root.
   - Navigate to `http://localhost/VoteXpress_PHP-main/`

---

## 📁 Project Structure
```text
├── admin/               # Administrative Command Center (Dashboard, Registry, Results)
├── voter/               # Voter-facing modules (Login, Ballot submission)
├── includes/            # Reusable components (Header, Navbar, Footer)
├── assets/
│   ├── css/             # Premium Style Sheets
│   ├── images/          # Uploaded Nominee/Voter assets
│   └── js/              # Interaction scripts
├── db_connect.php       # Database connectivity singleton
└── index.php            # Primary entry gateway
```

---

## 🛡️ Security Protocols
- **Session Hijacking Protection**: Encrypted session handling for both voters and admins.
- **SQL Injection Prevention**: Prepared statements and real-escape string sanitization.
- **Password Salting**: Military-grade hashing for all sensitive credentials.
- **Viewport Guards**: Responsive boundaries to prevent UI breakage on diverse devices.

---
## Screen shots:
![Home page](https://github.com/Manajit6776/VoteXpress_PHP/blob/main/Screenshot%20(295).png)
![Access Portal](https://github.com/Manajit6776/VoteXpress_PHP/blob/main/Screenshot%20(296).png)
![Voter Login](https://github.com/Manajit6776/VoteXpress_PHP/blob/main/Screenshot%20(297).png)
![Admin Login](https://github.com/Manajit6776/VoteXpress_PHP/blob/main/Screenshot%20(298).png)
![Admin Dashboard](https://github.com/Manajit6776/VoteXpress_PHP/blob/main/Screenshot%20(300).png)

**Developed with ❤️ by the VoteXpress Team.**
*"Securing every voice, one fragment at a time."*
