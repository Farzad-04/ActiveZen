<?php
// Include the header layout and database connection functions
include "layout/header.php";
include "tools/db.php"; // Include the db.php file to use the connection function

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in by verifying the session ID
if (!isset($_SESSION["User_id"])) {
    // Redirect to the login page if the user is not logged in
    header("location: /Data_Management_Project/login.php");
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION["User_id"];

// Connect to the database
$conn = getDatabaseConnection(); // Call function to establish a DB connection from db.php

// Flag to track if a workout was deleted
$workout_deleted = false;
$error_message = ""; // Initialize error message in case of failure

// Handle the POST request for workout deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_workout_id"])) {
    // Get the workout ID to be deleted
    $workout_id = intval($_POST["delete_workout_id"]);
    
    // Prepare the DELETE query to remove the workout
    $delete_query = "DELETE FROM workout_tracker WHERE Workout_id = ? AND User_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $workout_id, $user_id); // Bind the parameters for the query
    
    // Execute the query and check for success
    if ($stmt->execute()) {
        // Set flag if deletion is successful
        $workout_deleted = true;
    } else {
        // Set error message if deletion fails
        $error_message = "Failed to delete workout. Please try again.";
    }
    $stmt->close(); // Close the prepared statement
}

// Fetch all workouts for the logged-in user from the database
$query = "SELECT Workout_id, Workout_type, Duration, Calories_burned, Date_time, Notes 
          FROM workout_tracker WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // Bind the user ID to the query
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result set

// Fetch all the workouts as an associative array
$workouts = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close(); // Close the prepared statement
$conn->close(); // Close the database connection
?>

<!-- HTML for displaying the workout tracker table -->
<div class="container mt-5">
    <h2 class="text-center" style="color: #7C0A02;">Your Workout Tracker</h2>
    
    <?php if (count($workouts) > 0): ?>
        <!-- Display the table if there are workouts -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Workout Type</th>
                        <th>Duration (minutes)</th>
                        <th>Calories Burned</th>
                        <th>Date & Time</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workouts as $workout): ?>
                        <!-- Display each workout's details -->
                        <tr>
                            <td><?php echo htmlspecialchars($workout["Workout_type"]); ?></td>
                            <td><?php echo htmlspecialchars($workout["Duration"]); ?></td>
                            <td><?php echo htmlspecialchars($workout["Calories_burned"]); ?></td>
                            <td><?php echo htmlspecialchars($workout["Date_time"]); ?></td>
                            <td><?php echo htmlspecialchars($workout["Notes"]); ?></td>
                            <td>
                                <!-- Form to delete a workout, with confirmation before submitting -->
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this workout?');">
                                    <input type="hidden" name="delete_workout_id" value="<?php echo $workout["Workout_id"]; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Message if no workouts are found -->
        <p class="text-center mt-4">No workouts found. <a href="/Data_Management_Project/workout_tracker.php" class="text-primary">Log a new workout</a>.</p>
    <?php endif; ?>
</div>

<?php
// Show an alert if a workout was deleted or if there's an error
if ($workout_deleted): ?>
<script>
    alert("Workout deleted successfully!"); // Show success message
</script>
<?php elseif (!empty($error_message)): ?>
<script>
    alert("<?php echo $error_message; ?>"); // Show error message
</script>
<?php endif; ?>

<?php
// Include the footer layout
include "layout/footer.php";
?>
