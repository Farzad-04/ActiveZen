<?php
include "tools/db.php";
header("Content-Type: application/json");

// Check if the user is logged in as admin
session_start();
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

// Fetch all users
$conn = getDatabaseConnection();
$query = "SELECT User_id, Username FROM user";

if ($result = $conn->query($query)) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($users);
} else {
    echo json_encode(["error" => "Failed to fetch users"]);
}
?>
