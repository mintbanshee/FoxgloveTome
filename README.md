# 🌿 The Foxglove Tome 
**A Digital Sanctuary for Mental Wellness**

The Foxglove Tome is a web-based journal and mood-tracking application designed to provide a peaceful space for emotional reflection. Inspired by the resilience of nature, it features a "Mood Garden" that grows alongside the user's mental health journey.

## 📜 Progress Log
A focused page detailing my project progress can be found [on my portfolio](https://mintbanshee.dev/capstone.html) and is updated as I work on it (real-time progress)

## ✨ Features
* **Mood Garden**: A visual representation of your daily reflections.
* **Daily Journaling**: Secure, private entries to track thoughts and feelings.
* **Responsive Design**: Built with Bootstrap for a seamless experience on mobile and desktop.
* **Secure Backend**: Powered by PHP and MySQL for reliable data management.

## 🛠️ Tech Stack
* **Front-End**: HTML5, CSS3, Bootstrap 5 (Will transition to **React**)
* **Back-End**: PHP (OOP/PDO)
* **Database**: MySQL
* **Design**: Adobe Illustrator (Custom Logo)
* **Thoughts & Details**: My trusty notebook 

## 🌳 Project Structure

FoxgloveTome/
│
├── assets/
│   ├── css/                Stylesheets for the application
│   ├── images/             UI images and decorative assets
│   └── logo/               Branding and logo assets
│
├── auth/
│   ├── forgot_password.php Handles the password reset request form
│   ├── login.php           User login form
│   ├── require_admin.php   Access guard for admin-only pages
│   ├── require_login.php   Access guard for authenticated pages
│   ├── reset_password.php  Password reset form using secure token
│   └── signup.php          User registration form
│
├── config/
│   └── app.php             Application configuration and global settings
│
├── controllers/
│   ├── admin_controller.php Handles admin actions and admin routes
│   ├── auth_controller.php  Processes login, signup, logout, and password reset logic
│   └── entry_controller.php Handles journal entry creation and management
│
├── db/
│   └── database.php        Database connection using PDO
│
├── models/
│   ├── Garden.php          Model for the garden system (visual growth / future features)
│   ├── JournalEntry.php    Model for journal entry data and database interactions
│   └── User.php            Model for user accounts and authentication data
│
├── src/
│   └── package.json        Frontend dependencies or build configuration
│
├── views/
│   ├── admin/
│   │   └── admin_dashboard.php  Dashboard for administrative users
│   │
│   ├── journal/
│   │   └── new_entry.php        Form for creating a new journal entry
│   │
│   └── users/
│       └── user_dashboard.php   Dashboard for logged-in users
│
├── header.php              Shared site header template
├── footer.php              Shared site footer template
├── index.php               Main entry point for the application
├── notes.md                Development notes and planning
└── README.md               Project documentation


---
*Created with care by **MintBanshee** (Alexandria) as part of a Web & App Development Capstone project.*