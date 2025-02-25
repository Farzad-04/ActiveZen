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
    $sleep_hours = $_POST['sleep_hours'];
    $sleep_start = $_POST['sleep_start'];
    $sleep_end = $_POST['sleep_end'];
    $date = $_POST['date'];
    $notes = !empty($_POST['notes']) ? $_POST['notes'] : NULL;
    $sleep_quality = $_POST['sleep_quality'];

    // Validate the data
    if (empty($sleep_hours) || empty($sleep_start) || empty($sleep_end) || empty($date) || empty($sleep_quality)) {
        echo "<p class='text-danger'>Please fill in all required fields.</p>";
    } else {
        // Get the logged-in user's ID
        $user_id = $_SESSION["User_id"];

        // Prepare the SQL query to insert the sleep data into the database
        $sql = "INSERT INTO sleep (User_id, Sleep_hours, Sleep_start, Sleep_end, Date, Notes, Sleep_quality) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("idsssii", $user_id, $sleep_hours, $sleep_start, $sleep_end, $date, $notes, $sleep_quality);

            if ($stmt->execute()) {
                // Redirect to the confirmation page
                header("Location: /Data_Management_Project/save_sleep.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "<p class='text-danger'>Failed to log sleep. Please try again.</p>";
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
    <title>Sleep Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2018/01/18/18/36/sleep-3094544_1280.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 50px auto;
            max-width: 1200px;
            padding: 20px;
            background-color: #CBC4B4; /* Beige border color */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            max-width: 600px;
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            max-width: 400px;
        }

        .image-container img {
            width: 300px;
            height: 300px;
            border-radius: 50%; /* Circular image */
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .image-container img:hover {
            transform: scale(1.05);
        }

        footer, header {
            z-index: 1;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Form Section -->
        <div class="form-container">
            <h2>Sleep Tracker</h2>
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="sleep_hours">Sleep Hours</label>
                    <input type="number" step="0.1" id="sleep_hours" name="sleep_hours" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sleep_start">Sleep Start Time</label>
                    <input type="time" id="sleep_start" name="sleep_start" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sleep_end">Sleep End Time</label>
                    <input type="time" id="sleep_end" name="sleep_end" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="notes">Notes (255 characters max)</label>
                    <textarea id="notes" name="notes" class="form-control" maxlength="255" rows="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="sleep_quality">Sleep Quality (1-5)</label>
                    <input type="number" id="sleep_quality" name="sleep_quality" class="form-control" min="1" max="5" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log Sleep</button>
            </form>
        </div>

        <!-- Image Section -->
        <div class="image-container">
            <a href="/Data_Management_Project/all_sleep.php">
                <img src="https://news.llu.edu/sites/news.llu.edu/files/styles/crop_featured_image/public/istock-1145640846.jpg?itok=z5gMjClg" alt="View All Sleep Entries">
            </a>
        </div>
    </div>
</body>
</html>

<?php include "layout/footer.php"; ?>




