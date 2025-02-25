<?php
include "tools/db.php";
header("Content-Type: application/json");
session_start(); // Ensure the session is started

// Ensure the user is authenticated as an admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    echo json_encode(["error" => "Unauthorized access", "debug" => "No is_admin in session"]);
    exit;
}

// Get the user_id from the GET request
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo json_encode(["error" => "User ID is required"]);
    exit;
}

$user_id = intval($_GET['user_id']);

// Fetch workout tracker
$conn = getDatabaseConnection();
$query = "SELECT * FROM workout_tracker WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$workout_goals = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($workout_goals);

$stmt->close();
$conn->close();
?>
