<?php
include "tools/db.php";
header("Content-Type: application/json");

// Check if the user is logged in as admin
session_start();
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

// Get the user_id from the request
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if (!$user_id) {
    echo json_encode(["error" => "User ID is required"]);
    exit;
}

// Fetch nutrition tracker
$conn = getDatabaseConnection();
$query = "SELECT * FROM nutrition_tracker WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$nutrition_goals = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($nutrition_goals);
