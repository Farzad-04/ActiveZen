<?php
include "layout/header.php";
include "tools/db.php"; // Database connection

// Check if the user is logged in
if (!isset($_SESSION["User_id"])) {
    header("location: /Data_Management_Project/login.php");
    exit;
}

// Initialize variables
$user_id = $_SESSION["User_id"];
$view_name = isset($_GET['view']) ? $_GET['view'] : '';
$valid_views = [
    "WorkoutSummaryDetails",
    "HighestCalorieMeal",
    "UsersGoalsSummary",
    "StressVsSleep",
    "DailyCalories",
    "WorkoutsAllTime",
    "AverageSleepHours",
    "DailyWater",
    "HighStressLevels"
];

$data = [];
$error_message = "";

// Views that use different column names for the user ID
$views_user_column_map = [
    "WorkoutSummaryDetails" => "UserID",
    "HighestCalorieMeal" => "ID",
    "UsersGoalsSummary" => "User_id",
    "StressVsSleep" => "ID",
    "DailyCalories" => "ID",
    "WorkoutsAllTime" => "ID",
    "AverageSleepHours" => "ID",
    "DailyWater" => "ID",
    "HighStressLevels" => "ID"
];

// Get the database connection
$conn = getDatabaseConnection();

// Fetch data from the selected view
if ($view_name && in_array($view_name, $valid_views)) {
    $user_column = isset($views_user_column_map[$view_name]) ? $views_user_column_map[$view_name] : null;

    if ($user_column) {
        // Query for views with user-specific filtering
        $query = "SELECT * FROM $view_name WHERE $user_column = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
    } else {
        // Query for views without user-specific filtering
        $query = "SELECT * FROM $view_name";
        $stmt = $conn->prepare($query);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error_message = "Failed to retrieve data from the view.";
    }
    $stmt->close();
} else {
    $error_message = "Invalid view selected.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Views</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Filter and View Data</h2>
    
    <!-- Dropdown for selecting views -->
    <form method="GET" action="Views.php" class="mb-4">
        <div class="input-group">
            <select name="view" class="form-select">
                <option value="" disabled selected>Select a view</option>
                <?php foreach ($valid_views as $view): ?>
                    <option value="<?php echo $view; ?>" <?php echo ($view === $view_name) ? 'selected' : ''; ?>>
                        <?php echo $view; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Display results in a table -->
    <?php if ($view_name && $data): ?>
        <h4 class="text-center">Results from: <?php echo htmlspecialchars($view_name); ?></h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <?php foreach (array_keys($data[0]) as $column): ?>
                            <th><?php echo htmlspecialchars($column); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?php echo htmlspecialchars($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($view_name): ?>
        <p class="text-center">No data available for the selected view.</p>
    <?php endif; ?>

    <!-- Error message -->
    <?php if ($error_message): ?>
        <p class="text-center text-danger"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
</div>
</body>
</html>
<?php include "layout/footer.php"; ?>
