# Scammer Tracker v2

A lightweight, responsive, and self-hosted PHP tool to collect, store, and display scammer information — built with SQLite and secured admin access.

---

## 🚀 Features

- No MySQL required — uses local SQLite database
- Fully responsive design (desktop table + mobile card layout)
- Secure admin login with hashed passwords
- Admin panel to add scammers and manage users
- Modular structure for easy deployment
- Simple deployment — works out of the box on PHP hosting

---

## 📂 Folder Structure

```
scammer_tracker_v2/
├── admin/
│   ├── index.php          # Admin dashboard (add/view)
│   ├── login.php          # Admin login
│   ├── logout.php         # Logout script
│   └── manage_users.php   # Add new admin users
├── css/
│   └── style.css          # Basic styles
├── config.php             # SQLite connection
├── index.php              # Public scammer viewer (desktop/mobile)
├── scammers_schema.sql    # DB schema + default admin
```

---

## 🛠️ Installation

1. Upload all files to your PHP-capable web host.
2. Run this command to set up the database:

   ```bash
   sqlite3 scammers.sqlite < scammers_schema.sql
   ```

3. Visit `/admin/login.php` and log in with:
   - **Username:** `admin`
   - **Password:** `admin`

4. Change your password after first login via `manage_users.php`.

---

## 📱 Mobile UX

- Table view on desktop
- Clean stacked card layout on mobile
- Automatic layout switching via media queries

---

## ⚠️ Security Tips

- Replace the default admin credentials.
- Block direct access to `scammers.sqlite` by adding this to your `.htaccess` file (Apache only):

   ```apache
   <Files "scammers.sqlite">
     Order allow,deny
     Deny from all
   </Files>
   ```

---

## 🧪 Requirements

- PHP 7.2+ with SQLite support
- Web server (Apache, NGINX, etc.)

---

## 👨‍💻 Author

Made with ❤️ by [@rhcp011235](https://github.com/rhcp011235)  
2025 © All Rights Reserved

---

## 📜 License

This project is licensed under the MIT License. See `LICENSE` for details.
