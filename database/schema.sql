-- ActiveZen database schema (MySQL / MariaDB, works with XAMPP and MySQL Workbench)
--
-- This file was rebuilt from the application code after the original export was
-- lost: every table and column the PHP pages use is here, and the nine "views"
-- are reconstructed from how Views.php and stress_vs_sleep.php query them.
--
-- Import it in phpMyAdmin (Import tab) or run:  mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS `activezen`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `activezen`;

-- Drop in dependency order so the script can be re-run safely
DROP VIEW IF EXISTS `WorkoutSummaryDetails`;
DROP VIEW IF EXISTS `HighestCalorieMeal`;
DROP VIEW IF EXISTS `UsersGoalsSummary`;
DROP VIEW IF EXISTS `StressVsSleep`;
DROP VIEW IF EXISTS `DailyCalories`;
DROP VIEW IF EXISTS `WorkoutsAllTime`;
DROP VIEW IF EXISTS `AverageSleepHours`;
DROP VIEW IF EXISTS `DailyWater`;
DROP VIEW IF EXISTS `HighStressLevels`;
DROP TABLE IF EXISTS `BodySize`;
DROP TABLE IF EXISTS `mentalwellbeing`;
DROP TABLE IF EXISTS `nutrition_tracker`;
DROP TABLE IF EXISTS `nutritiongoals`;
DROP TABLE IF EXISTS `sleep`;
DROP TABLE IF EXISTS `workout_tracker`;
DROP TABLE IF EXISTS `workoutgoals`;
DROP TABLE IF EXISTS `admin`;
DROP TABLE IF EXISTS `user`;

-- ---------------------------------------------------------------- accounts
-- password / Password hold bcrypt hashes written by PHP's password_hash(), so they need 255 characters.
CREATE TABLE `user` (
  `User_id`       INT          NOT NULL PRIMARY KEY,
  `Fname`         VARCHAR(50)  NOT NULL,
  `Lname`         VARCHAR(50)  NOT NULL,
  `Username`      VARCHAR(50)  NOT NULL UNIQUE,
  `password`      VARCHAR(255) NOT NULL,
  `Email`         VARCHAR(100) NOT NULL,
  `Date_of_birth` DATE         NOT NULL,
  `Address`       VARCHAR(255) NULL,
  `Sex`           VARCHAR(10)  NOT NULL
);

CREATE TABLE `admin` (
  `Admin_id`      INT          NOT NULL PRIMARY KEY,
  `Username`      VARCHAR(50)  NOT NULL UNIQUE,
  `Password`      VARCHAR(255) NOT NULL,
  `Email`         VARCHAR(100) NOT NULL,
  `Sex`           VARCHAR(10)  NULL,
  `Date_of_birth` DATE         NULL,
  `Address`       VARCHAR(255) NULL
);

-- ---------------------------------------------------------------- tracking
CREATE TABLE `BodySize` (
  `BodySize_id` INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`     INT NOT NULL,
  `Date`        DATE NOT NULL,
  `Height`      DECIMAL(5,1) NOT NULL,
  `Waist_size`  DECIMAL(5,1) NOT NULL,
  `Chest_size`  DECIMAL(5,1) NOT NULL,
  `Hip_size`    DECIMAL(5,1) NOT NULL,
  `Arm_size`    DECIMAL(5,1) NOT NULL,
  `Thigh_size`  DECIMAL(5,1) NOT NULL,
  CONSTRAINT `fk_bodysize_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

CREATE TABLE `mentalwellbeing` (
  `W_id`             INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`          INT NOT NULL,
  `Mood`             VARCHAR(30) NOT NULL,
  `Mood_description` TEXT NULL,
  `Stress_level`     TINYINT NOT NULL,          -- form allows 1 to 10
  `Date`             DATE NOT NULL,
  CONSTRAINT `fk_mental_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

CREATE TABLE `nutrition_tracker` (
  `Nutrition_id` INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`      INT NOT NULL,
  `Meal_type`    VARCHAR(20) NOT NULL,          -- Breakfast, Lunch, Dinner, Snack, Water
  `Calories`     INT NOT NULL,
  `Protein`      INT NOT NULL,
  `Carbs`        INT NOT NULL,
  `Fats`         INT NOT NULL,
  `Water`        INT NOT NULL,
  `Date_time`    DATETIME NOT NULL,
  CONSTRAINT `fk_nutrition_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

CREATE TABLE `sleep` (
  `Sleep_id`      INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`       INT NOT NULL,
  `Sleep_hours`   DECIMAL(4,1) NOT NULL,
  `Sleep_start`   TIME NOT NULL,
  `Sleep_end`     TIME NOT NULL,
  `Date`          DATE NOT NULL,
  `Notes`         TEXT NULL,
  `Sleep_quality` TINYINT NOT NULL,             -- form allows 1 to 5
  CONSTRAINT `fk_sleep_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

CREATE TABLE `workout_tracker` (
  `Workout_id`      INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`         INT NOT NULL,
  `Workout_type`    VARCHAR(100) NOT NULL,
  `Duration`        INT NOT NULL,               -- minutes
  `Calories_burned` INT NOT NULL,
  `Date_time`       DATETIME NOT NULL,
  `Notes`           TEXT NULL,
  CONSTRAINT `fk_workout_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

-- ---------------------------------------------------------------- goals
CREATE TABLE `workoutgoals` (
  `workout_goal_id` INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`         INT NOT NULL,
  `Goal_type`       VARCHAR(100) NOT NULL,
  `Target_value`    INT NOT NULL,
  `Date_set`        DATE NOT NULL,
  `Target_date`     DATE NULL,
  `Frequency`       VARCHAR(10) NULL,           -- daily, weekly, monthly
  `Priority`        VARCHAR(10) NULL,           -- high, medium, low
  `status`          VARCHAR(10) NOT NULL,       -- active, inactive
  CONSTRAINT `fk_workoutgoals_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

CREATE TABLE `nutritiongoals` (
  `nutrition_goal_id` INT AUTO_INCREMENT PRIMARY KEY,
  `User_id`           INT NOT NULL,
  `Nutrient`          VARCHAR(30) NOT NULL,     -- protein, calories, hydration, carbs
  `Target_amount`     INT NOT NULL,
  `Date_set`          DATE NOT NULL,
  `Target_date`       DATE NULL,
  `Frequency`         VARCHAR(10) NULL,
  `Priority`          VARCHAR(10) NULL,
  `Status`            VARCHAR(10) NOT NULL,
  CONSTRAINT `fk_nutritiongoals_user` FOREIGN KEY (`User_id`) REFERENCES `user`(`User_id`) ON DELETE CASCADE
);

-- ---------------------------------------------------------------- views
-- Views.php filters each view by the logged-in user, using these column names:
--   UserID  -> WorkoutSummaryDetails      User_id -> UsersGoalsSummary
--   ID      -> every other view

CREATE VIEW `WorkoutSummaryDetails` AS
SELECT u.`User_id` AS `UserID`, u.`Username`, w.`Workout_type`, w.`Duration`,
       w.`Calories_burned`, w.`Date_time`
FROM `user` u
JOIN `workout_tracker` w ON w.`User_id` = u.`User_id`;

CREATE VIEW `HighestCalorieMeal` AS
SELECT n.`User_id` AS `ID`, n.`Meal_type`, n.`Calories`, n.`Date_time`
FROM `nutrition_tracker` n
WHERE n.`Calories` = (SELECT MAX(n2.`Calories`) FROM `nutrition_tracker` n2 WHERE n2.`User_id` = n.`User_id`);

CREATE VIEW `UsersGoalsSummary` AS
SELECT u.`User_id`, u.`Username`,
       (SELECT COUNT(*) FROM `workoutgoals` wg WHERE wg.`User_id` = u.`User_id`) AS `Workout_Goals`,
       (SELECT COUNT(*) FROM `workoutgoals` wg WHERE wg.`User_id` = u.`User_id` AND wg.`status` = 'active') AS `Active_Workout_Goals`,
       (SELECT COUNT(*) FROM `nutritiongoals` ng WHERE ng.`User_id` = u.`User_id`) AS `Nutrition_Goals`,
       (SELECT COUNT(*) FROM `nutritiongoals` ng WHERE ng.`User_id` = u.`User_id` AND ng.`Status` = 'active') AS `Active_Nutrition_Goals`
FROM `user` u;

-- Used by the Stress vs Sleep chart: one row per stress entry and one per sleep entry
CREATE VIEW `StressVsSleep` AS
SELECT m.`User_id` AS `ID`, m.`Date` AS `Record_Date`, 'Stress' AS `Entry_Type`, m.`Stress_level` AS `StressOrSleepLevel`
FROM `mentalwellbeing` m
UNION ALL
SELECT s.`User_id`, s.`Date`, 'Sleep', s.`Sleep_hours`
FROM `sleep` s;

CREATE VIEW `DailyCalories` AS
SELECT `User_id` AS `ID`, DATE(`Date_time`) AS `Meal_Date`, SUM(`Calories`) AS `Total_Calories`
FROM `nutrition_tracker`
GROUP BY `User_id`, DATE(`Date_time`);

CREATE VIEW `WorkoutsAllTime` AS
SELECT `User_id` AS `ID`, COUNT(*) AS `Total_Workouts`, SUM(`Duration`) AS `Total_Minutes`,
       SUM(`Calories_burned`) AS `Total_Calories_Burned`
FROM `workout_tracker`
GROUP BY `User_id`;

CREATE VIEW `AverageSleepHours` AS
SELECT `User_id` AS `ID`, ROUND(AVG(`Sleep_hours`), 1) AS `Average_Sleep_Hours`
FROM `sleep`
GROUP BY `User_id`;

CREATE VIEW `DailyWater` AS
SELECT `User_id` AS `ID`, DATE(`Date_time`) AS `Water_Date`, SUM(`Water`) AS `Total_Water`
FROM `nutrition_tracker`
GROUP BY `User_id`, DATE(`Date_time`);

-- "High" stress = 7 or more on the 1-10 scale
CREATE VIEW `HighStressLevels` AS
SELECT `User_id` AS `ID`, `Mood`, `Stress_level`, `Date` AS `Record_Date`
FROM `mentalwellbeing`
WHERE `Stress_level` >= 7;
