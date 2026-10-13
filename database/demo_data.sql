-- OPTIONAL demo data for local testing and screenshots. Import AFTER schema.sql.
--
-- Demo logins (local use only - never import this on a public server):
--   User login   : User ID 1001   Password ActiveZenDemo1
--   User login   : User ID 1002   Password ActiveZenDemo1
--   Admin login  : Admin ID 1     Password ActiveZenAdmin1   (plus the admin access code from tools/config.local.php)
--
-- Passwords below are bcrypt hashes in the format PHP's password_hash() produces.

USE `activezen`;

INSERT INTO `user` (`User_id`,`Fname`,`Lname`,`Username`,`password`,`Email`,`Date_of_birth`,`Address`,`Sex`) VALUES
  (1001,'Alex','Morgan','alexm','$2y$10$tl7bqXsWvExcdyogpl35bO.Q1QmKz8ySh2GbnUxAkLMnbFhFy7D0K','alex@example.com','2002-04-18','12 Maple St, Toronto','female'),
  (1002,'Sam','Rivera','samr','$2y$10$Qbmn87ZXYoUB/mg9xC8oJOjWszSd6XtQIgKH8VRPZ4eOcQ/21PzRq','sam@example.com','2001-09-02','48 Lake Rd, Oshawa','male');

INSERT INTO `admin` (`Admin_id`,`Username`,`Password`,`Email`,`Sex`,`Date_of_birth`,`Address`) VALUES
  (1,'admin','$2y$10$/qiw2Uk/SG0dw9joCmkyyeDnjeqlvl9qNjRCbwb9y2Q1BbgC18fna','admin@example.com','other','1990-01-01','ActiveZen HQ');

INSERT INTO `sleep` (`User_id`,`Sleep_hours`,`Sleep_start`,`Sleep_end`,`Date`,`Notes`,`Sleep_quality`) VALUES
  (1001,7.5,'23:00:00','06:30:00','2026-10-05','Felt rested',4),
  (1001,6.0,'00:30:00','06:30:00','2026-10-06','Late night studying',2),
  (1001,8.0,'22:30:00','06:30:00','2026-10-07','Great sleep',5),
  (1001,6.5,'23:30:00','06:00:00','2026-10-08','Woke up once',3),
  (1001,5.5,'01:00:00','06:30:00','2026-10-09','Exam stress',2),
  (1001,9.0,'22:00:00','07:00:00','2026-10-10','Caught up on rest',5),
  (1001,7.0,'23:00:00','06:00:00','2026-10-11','Normal night',4),
  (1002,7.0,'23:15:00','06:15:00','2026-10-10','Weekend lie-in',4),
  (1002,6.5,'23:45:00','06:15:00','2026-10-11','Okay night',3);

INSERT INTO `mentalwellbeing` (`User_id`,`Mood`,`Mood_description`,`Stress_level`,`Date`) VALUES
  (1001,'Calm','Relaxed start to the week',4,'2026-10-05'),
  (1001,'Focused','Busy day of classes',6,'2026-10-06'),
  (1001,'Happy','Good workout helped',3,'2026-10-07'),
  (1001,'Anxious','Midterm coming up',7,'2026-10-08'),
  (1001,'Overwhelmed','Deadlines piling up',9,'2026-10-09'),
  (1001,'Relaxed','Weekend break',2,'2026-10-10'),
  (1001,'Okay','Back to the routine',5,'2026-10-11'),
  (1002,'Tired','Long shift at work',6,'2026-10-10'),
  (1002,'Happy','Played soccer',2,'2026-10-11');

INSERT INTO `nutrition_tracker` (`User_id`,`Meal_type`,`Calories`,`Protein`,`Carbs`,`Fats`,`Water`,`Date_time`) VALUES
  (1001,'Breakfast',420,22,50,14,250,'2026-10-05 08:00:00'),
  (1001,'Lunch',650,35,70,20,350,'2026-10-05 12:30:00'),
  (1001,'Dinner',780,40,80,28,300,'2026-10-05 19:00:00'),
  (1001,'Snack',180,6,22,8,500,'2026-10-05 15:30:00'),
  (1001,'Breakfast',430,22,50,14,250,'2026-10-06 08:00:00'),
  (1001,'Lunch',665,35,70,20,350,'2026-10-06 12:30:00'),
  (1001,'Dinner',760,40,80,28,300,'2026-10-06 19:00:00'),
  (1001,'Snack',180,6,22,8,500,'2026-10-06 15:30:00'),
  (1001,'Breakfast',440,22,50,14,250,'2026-10-07 08:00:00'),
  (1001,'Lunch',680,35,70,20,350,'2026-10-07 12:30:00'),
  (1001,'Dinner',740,40,80,28,300,'2026-10-07 19:00:00'),
  (1001,'Snack',180,6,22,8,500,'2026-10-07 15:30:00'),
  (1001,'Breakfast',450,22,50,14,250,'2026-10-08 08:00:00'),
  (1001,'Lunch',695,35,70,20,350,'2026-10-08 12:30:00'),
  (1001,'Dinner',720,40,80,28,300,'2026-10-08 19:00:00'),
  (1001,'Snack',180,6,22,8,500,'2026-10-08 15:30:00'),
  (1001,'Breakfast',460,22,50,14,250,'2026-10-09 08:00:00'),
  (1001,'Lunch',710,35,70,20,350,'2026-10-09 12:30:00'),
  (1001,'Dinner',700,40,80,28,300,'2026-10-09 19:00:00'),
  (1001,'Snack',180,6,22,8,500,'2026-10-09 15:30:00'),
  (1002,'Lunch',700,38,75,22,400,'2026-10-11 13:00:00');

INSERT INTO `workout_tracker` (`User_id`,`Workout_type`,`Duration`,`Calories_burned`,`Date_time`,`Notes`) VALUES
  (1001,'Running',35,320,'2026-10-05 07:00:00','5 km easy pace'),
  (1001,'Weight training',50,280,'2026-10-07 18:00:00','Upper body'),
  (1001,'Cycling',45,400,'2026-10-09 17:30:00','Along the lakeshore'),
  (1001,'Yoga',30,120,'2026-10-10 10:00:00','Stretching session'),
  (1001,'Running',40,360,'2026-10-11 08:00:00','Intervals'),
  (1002,'Soccer',60,500,'2026-10-11 16:00:00','Pickup game');

INSERT INTO `workoutgoals` (`User_id`,`Goal_type`,`Target_value`,`Date_set`,`Target_date`,`Frequency`,`Priority`,`status`) VALUES
  (1001,'Run 5 km',5,'2026-10-01','2026-11-01','weekly','high','active'),
  (1001,'Workouts per week',4,'2026-10-01','2026-12-01','weekly','medium','active'),
  (1002,'Play soccer',2,'2026-10-03','2026-12-15','weekly','low','inactive');

INSERT INTO `nutritiongoals` (`User_id`,`Nutrient`,`Target_amount`,`Date_set`,`Target_date`,`Frequency`,`Priority`,`Status`) VALUES
  (1001,'protein',120,'2026-10-01','2026-12-01','daily','high','active'),
  (1001,'hydration',2000,'2026-10-01','2026-11-15','daily','medium','active'),
  (1002,'calories',2400,'2026-10-03',NULL,'daily','low','active');

INSERT INTO `BodySize` (`User_id`,`Date`,`Height`,`Waist_size`,`Chest_size`,`Hip_size`,`Arm_size`,`Thigh_size`) VALUES
  (1001,'2026-09-15',168.0,74.0,90.0,96.0,28.0,55.0),
  (1001,'2026-10-12',168.0,73.0,90.5,95.5,28.5,55.0),
  (1002,'2026-10-03',180.0,82.0,100.0,98.0,33.0,60.0);
