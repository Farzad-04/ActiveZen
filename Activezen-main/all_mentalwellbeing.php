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
$entry_deleted = false;
$error_message = "";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_entry_id"])) {
    $entry_id = intval($_POST["delete_entry_id"]);
    
    // Prepare a statement to delete the mental wellbeing entry
    $delete_query = "DELETE FROM mentalwellbeing WHERE W_id = ? AND User_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $entry_id, $user_id);
    
    if ($stmt->execute()) {
        $entry_deleted = true;
    } else {
        $error_message = "Failed to delete mental wellbeing entry. Please try again.";
    }
    $stmt->close();
}

// Fetch all mental wellbeing entries for the logged-in user
$query = "SELECT W_id, Mood, Mood_description, Stress_level, Date 
          FROM mentalwellbeing WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch entries as an associative array
$entries = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <h2 class="text-center" style="color: #7C0A02;">Your Mental Wellbeing Tracker</h2>
    
    <?php if (count($entries) > 0): ?>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Mood</th>
                        <th>Mood Description</th>
                        <th>Stress Level</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entries as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry["Mood"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Mood_description"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Stress_level"]); ?> / 10</td>
                            <td><?php echo htmlspecialchars($entry["Date"]); ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                    <input type="hidden" name="delete_entry_id" value="<?php echo $entry["W_id"]; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center mt-4">No mental wellbeing entries found. <a href="/Data_Management_Project/mentalWellbeingTracker.php" class="text-primary">Log a new entry</a>.</p>
    <?php endif; ?>
</div>

<!-- Include JavaScript to show prompt -->
<?php if ($entry_deleted): ?>
<script>
    alert("Mental wellbeing entry deleted successfully!");
</script>
<?php elseif (!empty($error_message)): ?>
<script>
    alert("<?php echo $error_message; ?>");
</script>
<?php endif; ?>

<?php include "layout/footer.php"; ?>
