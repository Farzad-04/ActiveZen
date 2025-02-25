<?php
include "layout/header.php";
include "tools/db.php"; // Include the db.php file to use the connection function

// Check if the user is logged in
if (!isset($_SESSION["User_id"])) {
    header("location: /Data_Management_Project/login.php");
    exit;
}

// Get the database connection using the function from db.php
$conn = getDatabaseConnection();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $goal_type = $_POST['goal_type'];
    $target_value = $_POST['target_value'];
    $date_set = $_POST['date_set'];
    
    // Set optional fields to NULL if not provided
    $target_date = !empty($_POST['target_date']) ? $_POST['target_date'] : NULL;
    $frequency = !empty($_POST['frequency']) ? $_POST['frequency'] : NULL;
    $priority = !empty($_POST['priority']) ? $_POST['priority'] : NULL;
    $status = $_POST['status'];

    // Validate the data (basic checks)
    if (empty($goal_type) || empty($target_value) || empty($date_set) || empty($status)) {
        echo "<p class='text-danger'>Please fill in all required fields.</p>";
    } else {
        // Get the logged-in user's ID
        $user_id = $_SESSION["User_id"];

        // Prepare the SQL query to insert the goal into the database
        $sql = "INSERT INTO workoutgoals (User_id, Goal_type, Target_value, Date_set, Target_date, Frequency, Priority, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isssssss", $user_id, $goal_type, $target_value, $date_set, $target_date, $frequency, $priority, $status);

            if ($stmt->execute()) {
                // Redirect to the new page after successful goal submission
                header("Location: /Data_Management_Project/Workoutgoalsuccessful.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "<p class='text-danger'>Failed to set goal. Please try again.</p>";
            }
            $stmt->close(); // Close the prepared statement
        } else {
            echo "<p class='text-danger'>Error preparing statement.</p>";
        }
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Gym Goal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://media.istockphoto.com/id/1450995510/vector/fitness-equipment-seamless-pattern-with-kettlebell-dumbbell-and-ab-roller-cartoon-flat.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            position: relative;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #7C0A02; /* Dark red theme */
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #7C0A02;
            border: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #590801;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border: 2px solid #7C0A02;
            border-radius: 5px;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://img.freepik.com/premium-photo/background-empty-gym-copy-space_190575-488.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            opacity: 0.5;
            z-index: -1;
        }

        .container {
            margin-top: 50px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-container {
            width: 48%; /* Left section width */
        }

        .image-container {
            width: 48%; /* Right section width */
        }

        .image-container img {
            width: 100%;
            border-radius: 10px;
        }

        .view-goals-btn {
            display: block;
            width: 100%;
            background-color: #7C0A02;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }

        .view-goals-btn:hover {
            background-color: #590801;
        }


        .image-container {
            position: relative;
            width: 50%; /* Adjust width as needed */
            max-width: 500px; /* Max width for responsiveness */
        }

        .image-container img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 50%;

        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 140, 186, 0.7); /* Semi-transparent blue */
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
            border-radius: 50%;

        }

        .image-container:hover .image-overlay {
            height: 100%;
        }

        .overlay-text {
            color: white;
            font-size: 24px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
            cursor: pointer;
        }

        /* Optional: Styling for the link */
        .image-overlay a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <!-- Form Section -->
            <div class="form-container">
                <h2>Set Your Workout Goal</h2>
                <form method="POST" action="">
                    <div class="form-group mb-3">
                        <label for="goal_type">Goal Type</label>
                        <input type="text" id="goal_type" name="goal_type" class="form-control" value="<?php echo isset($_POST['goal_type']) ? $_POST['goal_type'] : ''; ?>" >
                    </div>

                    <div class="form-group mb-3">
                        <label for="target_value">Target Value</label>
                        <input type="number" id="target_value" name="target_value" class="form-control" value="<?php echo isset($_POST['target_value']) ? $_POST['target_value'] : ''; ?>" >
                    </div>

                    <div class="form-group mb-3">
                        <label for="date_set">Date Set</label>
                        <input type="date" id="date_set" name="date_set" class="form-control" value="<?php echo isset($_POST['date_set']) ? $_POST['date_set'] : ''; ?>" >
                    </div>

                    <div class="form-group mb-3">
                        <label for="target_date">Target Date</label>
                        <input type="date" id="target_date" name="target_date" class="form-control" value="<?php echo isset($_POST['target_date']) ? $_POST['target_date'] : ''; ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="frequency">Frequency</label>
                        <select id="frequency" name="frequency" class="form-control">
                            <option value="">Select Frequency</option>
                            <option value="daily" <?php echo (isset($_POST['frequency']) && $_POST['frequency'] == 'daily') ? 'selected' : ''; ?>>Daily</option>
                            <option value="weekly" <?php echo (isset($_POST['frequency']) && $_POST['frequency'] == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                            <option value="monthly" <?php echo (isset($_POST['frequency']) && $_POST['frequency'] == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority" class="form-control">
                            <option value="">Select Priority</option>
                            <option value="high" <?php echo (isset($_POST['priority']) && $_POST['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
                            <option value="medium" <?php echo (isset($_POST['priority']) && $_POST['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="low" <?php echo (isset($_POST['priority']) && $_POST['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (isset($_POST['status']) && $_POST['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit Goal</button>
                
                </form>
            </div>

            <!-- Image Section -->
            

<div class="image-container">
    <img src="https://jobsforeditors.com/blog/wp-content/uploads/2018/11/How-to-measure-your-goals-as-a-writer.jpg" alt="Gym Image">
    <div class="image-overlay">
        <div class="overlay-text">
            <a href="/Data_Management_Project/allworkoutgoals.php">View Goals</a> <!-- Replace with your desired URL -->
        </div>
    </div>
</div>
        </div>
    </div>
</body>
</html>


<?php include "layout/footer.php"; ?>
