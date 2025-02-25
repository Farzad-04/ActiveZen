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
$sleep_deleted = false;
$error_message = "";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_sleep_id"])) {
    $sleep_id = intval($_POST["delete_sleep_id"]);
    
    // Prepare a statement to delete the sleep entry
    $delete_query = "DELETE FROM sleep WHERE Sleep_id = ? AND User_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $sleep_id, $user_id);
    
    if ($stmt->execute()) {
        $sleep_deleted = true;
    } else {
        $error_message = "Failed to delete sleep entry. Please try again.";
    }
    $stmt->close();
}

// Fetch all sleep entries for the logged-in user
$query = "SELECT Sleep_id, Sleep_hours, Sleep_start, Sleep_end, Date, Notes, Sleep_quality 
          FROM sleep WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch sleep entries as an associative array
$sleeps = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <h2 class="text-center" style="color: #7C0A02;">Your Sleep Tracker</h2>
    
    <?php if (count($sleeps) > 0): ?>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Sleep Hours</th>
                        <th>Sleep Start</th>
                        <th>Sleep End</th>
                        <th>Date</th>
                        <th>Sleep Quality</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sleeps as $sleep): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sleep["Sleep_hours"]); ?></td>
                            <td><?php echo htmlspecialchars($sleep["Sleep_start"]); ?></td>
                            <td><?php echo htmlspecialchars($sleep["Sleep_end"]); ?></td>
                            <td><?php echo htmlspecialchars($sleep["Date"]); ?></td>
                            <td><?php echo htmlspecialchars($sleep["Sleep_quality"]); ?> / 5</td>
                            <td><?php echo htmlspecialchars($sleep["Notes"]); ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this sleep entry?');">
                                    <input type="hidden" name="delete_sleep_id" value="<?php echo $sleep["Sleep_id"]; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center mt-4">No sleep entries found. <a href="/Data_Management_Project/sleep.php" class="text-primary">Log a new sleep entry</a>.</p>
    <?php endif; ?>
</div>

<!-- Include JavaScript to show prompt -->
<?php if ($sleep_deleted): ?>
<script>
    alert("Sleep entry deleted successfully!");
</script>
<?php elseif (!empty($error_message)): ?>
<script>
    alert("<?php echo $error_message; ?>");
</script>
<?php endif; ?>

<?php include "layout/footer.php"; ?>
