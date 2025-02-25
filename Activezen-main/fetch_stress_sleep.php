<?php
include "tools/db.php";
header("Content-Type: application/json");
session_start();

// Debugging: Check if User_id is in the session
if (!isset($_SESSION["User_id"])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized access", "debug" => "No User_id in session"]);
    exit;
}

$user_id = $_SESSION["User_id"];

// Connect to the database
$conn = getDatabaseConnection();

// Query the `stressvsleep` view for the logged-in user
$query = "SELECT Record_Date, Entry_Type, StressOrSleepLevel FROM stressvsleep WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_all(MYSQLI_ASSOC);

// Debugging: Check if the view returned any data
if (empty($data)) {
    echo json_encode(["error" => "No data found for the user", "user_id" => $user_id]);
    exit;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
