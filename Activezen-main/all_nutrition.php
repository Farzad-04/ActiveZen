<?php
include "layout/header.php";
include "tools/db.php"; // Include the db.php file to use the connection function

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["User_id"])) {
    header("location: /Data_Management_Project/login.php");
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION["User_id"];

// Connect to the database
$conn = getDatabaseConnection(); // Function assumed to be in db.php

// Flag to track deletion status
$nutrition_deleted = false;
$error_message = "";
// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_nutrition_id"])) {
    $nutrition_id = intval($_POST["delete_nutrition_id"]);
    
    // Prepare a statement to delete the nutrition entry
    $delete_query = "DELETE FROM nutrition_tracker WHERE Nutrition_id = ? AND User_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $nutrition_id, $user_id);
    
    if ($stmt->execute()) {
        $nutrition_deleted = true;
    } else {
        $error_message = "Failed to delete nutrition entry. Please try again.";
    }
    $stmt->close();
}

// Fetch all nutrition entries for the logged-in user
$query = "SELECT Nutrition_id, Meal_type, Calories, Protein, Carbs, Fats, Water, Date_time 
          FROM nutrition_tracker WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch nutrition entries as an associative array
$nutrition_entries = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <!-- Display title for the Nutrition Tracker -->
    <h2 class="text-center" style="color: #7C0A02;">Your Nutrition Tracker</h2>
    
    <!-- Check if there are any nutrition entries to display -->
    <?php if (count($nutrition_entries) > 0): ?>
        <!-- Display the table if there are nutrition entries -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <!-- Table headers -->
                <thead class="table-dark">
                    <tr>
                        <th>Meal Type</th>
                        <th>Calories</th>
                        <th>Protein (g)</th>
                        <th>Carbs (g)</th>
                        <th>Fats (g)</th>
                        <th>Water (ml)</th>
                        <th>Date & Time</th>
                        <th>Action</th> <!-- Action column for deleting entries -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each nutrition entry and display its data in a table row -->
                    <?php foreach ($nutrition_entries as $entry): ?>
                        <tr>
                            <!-- Display each entry's details in corresponding columns -->
                            <td><?php echo htmlspecialchars($entry["Meal_type"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Calories"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Protein"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Carbs"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Fats"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Water"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Date_time"]); ?></td>
                            <!-- Provide a delete button to remove a nutrition entry -->
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                    <!-- Hidden input to store the nutrition entry ID to delete -->
                                    <input type="hidden" name="delete_nutrition_id" value="<?php echo $entry["Nutrition_id"]; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- If no entries are found, display a message and link to log a new entry -->
        <p class="text-center mt-4">No nutrition entries found. <a href="/Data_Management_Project/nutrition_tracker.php" class="text-primary">Log a new entry</a>.</p>
    <?php endif; ?>
</div>

<!-- Display JavaScript alerts if an entry was deleted or if there was an error -->
<?php if ($nutrition_deleted): ?>
<script>
    // Show success alert if a nutrition entry was deleted
    alert("Nutrition entry deleted successfully!");
</script>
<?php elseif (!empty($error_message)): ?>
<script>
    // Show error alert if there was an issue deleting the entry
    alert("<?php echo $error_message; ?>");
</script>
<?php endif; ?>

<!-- Include the footer layout -->
<?php include "layout/footer.php"; ?>

