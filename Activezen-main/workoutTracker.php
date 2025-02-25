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
    $workout_type = $_POST['workout_type'];
    $duration = $_POST['duration'];
    $calories_burned = $_POST['calories_burned'];
    $date_time = $_POST['date_time'];
    $notes = !empty($_POST['notes']) ? $_POST['notes'] : NULL;

    // Validate the data
    if (empty($workout_type) || empty($duration) || empty($calories_burned) || empty($date_time)) {
        echo "<p class='text-danger'>Please fill in all required fields.</p>";
    } else {
        // Get the logged-in user's ID
        $user_id = $_SESSION["User_id"];

        // Prepare the SQL query to insert the workout into the database
        $sql = "INSERT INTO workout_tracker (User_id, Workout_type, Duration, Calories_burned, Date_time, Notes) 
                VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isiiss", $user_id, $workout_type, $duration, $calories_burned, $date_time, $notes);

            if ($stmt->execute()) {
                // Redirect to the confirmation page
                header("Location: \Data_Management_Project\save_workout.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "<p class='text-danger'>Failed to log workout. Please try again.</p>";
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
    <title>Workout Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .workout-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background-image: url('https://img.freepik.com/premium-photo/background-empty-gym-copy-space_190575-488.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            position: relative;
            padding: 20px;
            margin: 50px auto;
            max-width: 1200px;
            border-radius: 10px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            max-width: 600px;
            margin-right: 20px;
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

        .image-container {
            position: relative;
            flex: 1;
            max-width: 400px;
            text-align: center;
        }

        .image-container img {
            display: block;
            width: 300px;
            height: 300px;
            border-radius: 50%; /* Makes the image circular */
            margin: auto;
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 140, 186, 0.7);
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
            border-radius: 50%; /* Matches circular image */
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
            text-align: center;
        }

        .overlay-text a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>

    <div class="workout-container">
        <div class="form-container">
            <h2>Workout Tracker</h2>
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="workout_type">Workout Type</label>
                    <input type="text" id="workout_type" name="workout_type" class="form-control" maxlength="100" required>
                </div>
                <div class="form-group mb-3">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" id="duration" name="duration" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="calories_burned">Calories Burned</label>
                    <input type="number" id="calories_burned" name="calories_burned" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="date_time">Date & Time</label>
                    <input type="datetime-local" id="date_time" name="date_time" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="notes">Notes (500 characters max)</label>
                    <textarea id="notes" name="notes" class="form-control" maxlength="500" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log Workout</button>
            </form>
        </div>

        <div class="image-container">
            <img src="data:image/png;base64,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" alt="Gym Image">
            <div class="image-overlay">
                <div class="overlay-text">
                    <a href="/Data_Management_Project/all_workouts.php">View All Workouts</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include "layout/footer.php"; ?>



