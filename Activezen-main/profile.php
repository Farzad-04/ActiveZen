<?php
// Include the header layout file
include "layout/header.php";

// Check if a session is not already active before starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is authenticated
if (!isset($_SESSION["User_id"])) {
    // Redirect to login page if user is not logged in
    header("Location: /Data_Management_Project/login.php");
    exit;
}

// Retrieve user details from the session, or assign default values if not available
$first_name = $_SESSION["Fname"] ?? "N/A";
$last_name = $_SESSION["Lname"] ?? "N/A";
$gender = $_SESSION["Sex"] ?? "N/A";
$address = $_SESSION["Address"] ?? "N/A";
$username = $_SESSION["Username"] ?? "N/A";
$date_of_birth = $_SESSION["Date_of_birth"] ?? "N/A";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
      
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #E4CAA8;
            border: 2px solid #800000; 
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h2 {
            color: #b22222; 
            font-weight: 700;
        }

        .profile-details {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .profile-details:last-child {
            border-bottom: none;
        }

        .profile-details span {
            display: inline-block;
            width: 150px;
            font-weight: 600;
            color: #555;
        }

        .profile-actions {
            text-align: center;
            margin-top: 20px;
        }

        .btn-primary {
            background-color: #800000;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #b22222; 
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Welcome, <?= htmlspecialchars($first_name) ?>!</h2>
            <p>Your profile information is displayed below:</p>
        </div>
        <div class="profile-details">
            <span>First Name:</span> <?= htmlspecialchars($first_name) ?>
        </div>
        <div class="profile-details">
            <span>Last Name:</span> <?= htmlspecialchars($last_name) ?>
        </div>
        <div class="profile-details">
            <span>Gender:</span> <?= htmlspecialchars($gender) ?>
        </div>
        <div class="profile-details">
            <span>Address:</span> <?= htmlspecialchars($address) ?>
        </div>
        <div class="profile-details">
            <span>Username:</span> <?= htmlspecialchars($username) ?>
        </div>
        <div class="profile-details">
            <span>Date of Birth:</span> <?= htmlspecialchars($date_of_birth) ?>
        </div>
        <div class="profile-actions">
            <a href="/Data_Management_Project/Home.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>


<?php 
include "layout/footer.php";
?>
