<?php
session_start(); // Start session

// Check if the admin is logged in
if (isset($_SESSION["Admin_id"])) {
    // Unset all session variables related to the admin
    unset($_SESSION["Admin_id"]);
    unset($_SESSION["Admin_username"]);
    unset($_SESSION["Admin_email"]);
    // You can add more session variables to unset if needed

    // Destroy the session
    session_destroy();
}

// Redirect to the home page
header("Location: /Data_Management_Project/home.php");
exit;
?>
