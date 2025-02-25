# Fitness App
## Overview

The Fitness App is designed to help users efficiently track their health and fitness goals. It allows users to log workouts, monitor nutrition, track sleep patterns, and learn basic workouts through an integrated tutorial section. Additionally, the app provides interactive features such as graphs and detailed statistics to assess overall wellness. An admin section is also included for managing users.

This project was developed as the final group project for a Data Management class.

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

The app utilizes **MySQL Workbench** for database management. User and admin information, along with activity logs, are stored in structured tables, ensuring secure and efficient data handling.

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
