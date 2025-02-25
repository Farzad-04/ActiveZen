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
$goal_deleted = false;
$error_message = "";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_goal_id"])) {
    $goal_id = intval($_POST["delete_goal_id"]);
    
    // Prepare a statement to delete the goal
    $delete_query = "DELETE FROM nutritiongoals WHERE nutrition_goal_id = ? AND User_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $goal_id, $user_id);
    
    if ($stmt->execute()) {
        $goal_deleted = true;
    } else {
        $error_message = "Failed to delete goal. Please try again.";
    }
    $stmt->close();
}

// Fetch all nutrition goals for the logged-in user
$query = "SELECT nutrition_goal_id, Nutrient, Target_amount, Date_set, Target_date, Frequency, Priority, Status 
          FROM nutritiongoals WHERE User_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch goals as an associative array
$goals = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <h2 class="text-center" style="color: #7C0A02;">Your Nutrition Goals</h2>
    
    <?php if (count($goals) > 0): ?>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nutrient</th>
                        <th>Target Amount</th>
                        <th>Date Set</th>
                        <th>Target Date</th>
                        <th>Frequency</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($goals as $goal): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($goal["Nutrient"]); ?></td>
                            <td><?php echo htmlspecialchars($goal["Target_amount"]); ?></td>
                            <td><?php echo htmlspecialchars($goal["Date_set"]); ?></td>
                            <td><?php echo htmlspecialchars($goal["Target_date"]); ?></td>
                            <td><?php echo htmlspecialchars($goal["Frequency"]); ?></td>
                            <td><?php echo htmlspecialchars($goal["Priority"]); ?></td>
                            <td><?php echo htmlspecialchars($goal["Status"]); ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this goal?');">
                                    <input type="hidden" name="delete_goal_id" value="<?php echo $goal["nutrition_goal_id"]; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center mt-4">No nutrition goals found. <a href="/Data_Management_Project/set_goal.php" class="text-primary">Set a new goal</a>.</p>
    <?php endif; ?>
</div>

<!-- Include JavaScript to show prompt -->
<?php if ($goal_deleted): ?>
<script>
    alert("Goal deleted successfully!");
</script>
<?php elseif (!empty($error_message)): ?>
<script>
    alert("<?php echo $error_message; ?>");
</script>
<?php endif; ?>

<?php include "layout/footer.php"; ?>
