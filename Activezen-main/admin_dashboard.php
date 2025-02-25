<?php
// Start the session to manage user authentication
session_start();

// Include the header layout file
include "layout/header.php";

// Check if the admin is authenticated
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    // Redirect to the admin login page if not authenticated
    header("Location: /Data_Management_Project/admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Link to the Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        /* Container for the dashboard */
        .dashboard-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Header styling for the dashboard */
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Dashboard header text styling */
        .dashboard-header h1 {
            color: #007bff;
            font-size: 32px;
        }

        /* Styling for action cards container */
        .dashboard-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* Style for action links */
        .dashboard-actions a {
            text-decoration: none;
            color: white;
        }

        /* Style for individual action cards */
        .action-card {
            flex: 1 1 calc(33% - 20px); /* Responsive width for cards */
            max-width: 250px;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            transition: transform 0.2s ease-in-out; /* Smooth hover animation */
        }

        /* Hover effect for action cards */
        .action-card:hover {
            transform: scale(1.05); /* Slightly enlarge the card */
            background-color: #0056b3; /* Darker shade of blue */
        }

        /* Styling for card headings */
        .action-card h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        /* Styling for card descriptions */
        .action-card p {
            font-size: 14px;
        }

        /* Styling for logout action card */
        .logout-card {
            background-color: #dc3545; /* Red color for logout */
        }
    </style>
</head>
<body>
    <!-- Main container for the admin dashboard -->
    <div class="dashboard-container">
        <!-- Dashboard header -->
        <div class="dashboard-header">
            <h1>Welcome, Admin</h1>
            <p>Select an action to manage the system.</p>
        </div>
        
        <!-- Actions available for the admin -->
        <div class="dashboard-actions">
            <!-- Manage Users card -->
            <div class="action-card">
                <h2>Manage Users</h2>
                <p>View and manage user data, workout goals, and nutrition goals.</p>
                <a href="/Data_Management_Project/user_data.php" class="btn btn-primary">Go</a>
            </div>

            <!-- Logout card -->
            <div class="action-card logout-card">
                <h2>Logout</h2>
                <p>End your session and return to the home page.</p>
                <a href="/Data_Management_Project/admin_logout.php" class="btn btn-danger">Go</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
// Include the footer layout file
include "layout/footer.php"; 
?>
