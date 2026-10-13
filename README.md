# ActiveZen Fitness App
## Overview

The Fitness App is designed to help users efficiently track their health and fitness goals. It allows users to log workouts, monitor nutrition, track sleep patterns, and learn basic workouts through an integrated tutorial section. Additionally, the app provides interactive features such as graphs and detailed statistics to assess overall wellness. An admin section is also included for managing users.

This project was developed as the final group project for a Data Management class.

## Running the project locally

Requirements: [XAMPP](https://www.apachefriends.org/) (Apache + PHP + MySQL).

1. **Start XAMPP.** In the XAMPP Control Panel, start **Apache** and **MySQL**.
2. **Copy the app.** Copy the `Activezen-main` folder into XAMPP's `htdocs` folder (`C:\xampp\htdocs` on Windows) and rename it `ActiveZen` (any name works).
3. **Create the database.** Open `http://localhost/phpmyadmin`, go to the **Import** tab, and import `database/schema.sql`. This creates the `activezen` database with all tables and views. For sample data to try the app (and take screenshots), also import `database/demo_data.sql`.
4. **Add your settings.** In `Activezen-main/tools/`, copy `config.example.php` to `config.local.php`. XAMPP's defaults (user `root`, empty password, port `3306`) already work. Set `admin_access_code` to a code of your choice if you want to use the admin area. If your MySQL runs on another port (MySQL Workbench setups often use `3308`), change `db_port` too.
5. **Open the app** at `http://localhost/ActiveZen/index.php`.

**Demo logins** (only exist if you imported `demo_data.sql`; local use only):

| Role  | ID | Password |
|-------|----|----------|
| User  | `1001` | `ActiveZenDemo1` |
| Admin | `1` (plus your admin access code) | `ActiveZenAdmin1` |

Users sign in with their numeric **User ID**, not their username.

### Alternative: macOS with Homebrew (no XAMPP)

```bash
brew install php mysql
brew services start mysql

# from the repo root
mysql -u root < database/schema.sql
mysql -u root < database/demo_data.sql      # optional sample data

cp Activezen-main/tools/config.example.php Activezen-main/tools/config.local.php
# edit config.local.php and set admin_access_code

cd Activezen-main
php -S localhost:8000
```

Then open `http://localhost:8000/index.php`.

**Troubleshooting**
- *Apache won't start*: another program is using port 80. Change Apache's port in XAMPP (Config, then `httpd.conf`) and use `http://localhost:8080/ActiveZen/`.
- *"Could not connect to the database"*: MySQL isn't running, or the values in `tools/config.local.php` don't match your MySQL setup.
- *Admin login says it is disabled*: set `admin_access_code` in `tools/config.local.php`.

## Security notes

- Passwords are stored as salted hashes (`password_hash` / `password_verify`), never as plain text.
- Database credentials and the admin access code are **not** in the code. They live in `tools/config.local.php`, which is ignored by git, or in environment variables (`ACTIVEZEN_DB_HOST`, `ACTIVEZEN_DB_USER`, `ACTIVEZEN_DB_PASS`, `ACTIVEZEN_DB_NAME`, `ACTIVEZEN_DB_PORT`, `ACTIVEZEN_ADMIN_CODE`).
- Database queries use prepared statements. The demo data is for local testing only and should never be imported on a public server.

## Features

### User Functionality

- **Account Creation and Login:**
 Users must sign up or log in to access the app.

- **Workout and Nutrition Goals:**
 Users can set personalized workout and nutrition targets.

- **Daily Tracking:**
  -  log completed workouts.
  -   Input food details, including calories and nutritional values.
  -   Record sleep patterns.
  -   Monitor mood changes.

- **Weather Information:**
 Users can check the weather within the app to plan outdoor activities.

- **Search and Filter:**
  - Search and filter stats, such as highest daily calorie intake.
  - Generate insights into health trends.

**Data Visualization:** Graphs display correlations between sleep and stress levels to help users identify health patterns.

**Workout Tutorials:** A tutorial section provides demonstrations of basic workout techniques.

### Admin Functionality

-**Admin Dashboard:**
  - View all active users.
  - Monitor user activity, including workout and nutrition logs.

## How It Works

**User Setup:**
  - Register a new account or log in with existing credentials.
  - Upon login, users gain access to all app features.

**Setting Goals**
  - Navigate to the Goals section to establish workout and nutrition targets.
    
**Daily Logs**
  - Use tracking features to log workouts, meals, sleep, and mood.

**Analytics**
  - Access personalized statistics through search and filter tools.
  - view graphical representations of sleep and stress correlations.**

**Admin Access**
  - Admins log in with separate credentials.
  - The admin panel provides oversight of user activity and engagement.

**Tutorials**
  - Access the tutorial section to learn essential workout routines.

## Database and Backend

### Database Storage

The app uses a **MySQL** database (`activezen`). Its structure is defined in `database/schema.sql`. User and admin information, along with activity logs, are stored in structured tables, ensuring secure and efficient data handling.

### Table Structures

**Admin Table:** Stores admin credentials and details.

**Body Size Table:** Tracks users' physical measurements.

**Mental Wellbeing Table:** Logs users' moods, stress levels, and mood descriptions.

**Nutrition Tracker Table:** Records users’ dietary intake, including calories, proteins, carbs, fats, and water.

**Nutrition Goals Table:**  Stores users' nutritional goals and progress.

**Sleep Table:** Tracks sleep duration, quality, and timing.

**User Table:** Maintains user details and login credentials.

**Workout Tracker Table:** Logs workout details, including type, duration, and calories burned.

**Workout Goals Table:** Stores users’ fitness goals and status.

### Backend Integration

The app leverages XAMPP to run PHP scripts that handle server-side processing. PHP manages user authentication, data input/output, and secure communication with the MySQL database.

## Acknowledgments

This app was developed as the final group project for a Data Management class. Special thanks to all team members for their dedication and contributions.
