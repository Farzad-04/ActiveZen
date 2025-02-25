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
$bodysize_deleted = false;
$error_message = "";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_bodysize_id"])) {
    $bodysize_id = intval($_POST["delete_bodysize_id"]);
    
    // Prepare a statement to delete the body size entry
    $delete_query = "DELETE FROM BodySize WHERE BodySize_id = ? AND User_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $bodysize_id, $user_id);
    
    if ($stmt->execute()) {
        $bodysize_deleted = true;
    } else {
        $error_message = "Failed to delete body size entry. Please try again.";
    }
    $stmt->close();
}

// Fetch all body size entries for the logged-in user
$query = "SELECT BodySize_id, Date, Height, Waist_size, Chest_size, Hip_size, Arm_size, Thigh_size 
          FROM BodySize WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch body size entries as an associative array
$bodysize_entries = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <!-- Display title for the Body Size Tracker page -->
    <h2 class="text-center" style="color: #7C0A02;">Your Body Size Tracker</h2>
    
    <!-- Check if there are any body size entries to display -->
    <?php if (count($bodysize_entries) > 0): ?>
        <!-- Display the table if there are body size entries -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <!-- Table headers for body size tracking -->
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Height (cm)</th>
                        <th>Waist Size (cm)</th>
                        <th>Chest Size (cm)</th>
                        <th>Hip Size (cm)</th>
                        <th>Arm Size (cm)</th>
                        <th>Thigh Size (cm)</th>
                        <th>Action</th> <!-- Action column for deleting entries -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each body size entry and display it in the table -->
                    <?php foreach ($bodysize_entries as $entry): ?>
                        <tr>
                            <!-- Display the details of each entry in corresponding columns -->
                            <td><?php echo htmlspecialchars($entry["Date"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Height"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Waist_size"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Chest_size"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Hip_size"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Arm_size"]); ?></td>
                            <td><?php echo htmlspecialchars($entry["Thigh_size"]); ?></td>
                            <!-- Provide a delete button for each entry -->
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                    <!-- Hidden input field to store the ID of the entry to be deleted -->
                                    <input type="hidden" name="delete_bodysize_id" value="<?php echo $entry["BodySize_id"]; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Display a message if no entries are found, with a link to add the first entry -->
        <p class="text-center mt-4">No body size entries found. <a href="/Data_Management_Project/track_body_size.php" class="text-primary">Add your first entry</a>.</p>
    <?php endif; ?>
</div>

<!-- Display JavaScript alerts if a body size entry was deleted or if an error occurred -->
<?php if ($bodysize_deleted): ?>
<script>
    // Show success alert if a body size entry was deleted
    alert("Body size entry deleted successfully!");
</script>
<?php elseif (!empty($error_message)): ?>
<script>
    // Show error alert if there was an issue deleting the entry
    alert("<?php echo $error_message; ?>");
</script>
<?php endif; ?>

<!-- Include the footer layout -->
<?php include "layout/footer.php"; ?>
