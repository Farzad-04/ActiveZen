<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
// Start the session
session_start();

// Clear all session variables
session_unset(); 

// Destroy the session
session_destroy();

// Redirect to home page
header("Location: /Data_Management_Project/Home.php");
exit;
?>
