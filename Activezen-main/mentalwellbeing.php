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
    $mood = $_POST['mood'];
    $mood_description = $_POST['mood_description'];
    $stress_level = $_POST['stress_level'];
    $date = $_POST['date'];

    // Validate the data
    if (empty($mood) || empty($stress_level) || empty($date)) {
        echo "<p class='text-danger'>Please fill in all required fields.</p>";
    } else {
        // Get the logged-in user's ID
        $user_id = $_SESSION["User_id"];

        // Prepare the SQL query to insert the mental wellbeing data into the database
        $sql = "INSERT INTO mentalwellbeing (User_id, Mood, Mood_description, Stress_level, Date) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("issis", $user_id, $mood, $mood_description, $stress_level, $date);

            if ($stmt->execute()) {
                // Redirect to the confirmation page
                header("Location: /Data_Management_Project/save_mentalwellbeing.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "<p class='text-danger'>Failed to log mental wellbeing data. Please try again.</p>";
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
    <title>Mental Wellbeing Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2017/10/27/14/09/relaxation-2897351_1280.jpg');
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

        .image-container {
            position: relative;
            width: 50%;
            margin: auto;
            text-align: center;
        }

        .image-container img {
            width: 200px;
            height: 200px;
            border-radius: 50%; /* Makes the image circular */
            object-fit: cover; /* Ensures the image is fully visible within the circular frame */
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
            transition: 0.5s ease;
            border-radius: 50%; /* Matches circular image */
        }

        .image-container:hover .image-overlay {
            height: 100%;
        }

        .overlay-text {
            color: white;
            font-size: 18px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            cursor: pointer;
        }

        .overlay-text a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Form Section -->
            <div class="form-container col-md-6">
                <h2>Mental Wellbeing Tracker</h2>
                <form method="POST" action="">
                    <div class="form-group mb-3">
                        <label for="mood">Mood</label>
                        <input type="text" id="mood" name="mood" class="form-control" maxlength="30" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="mood_description">Mood Description</label>
                        <textarea id="mood_description" name="mood_description" class="form-control" maxlength="255" rows="4"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="stress_level">Stress Level (1-10)</label>
                        <input type="number" id="stress_level" name="stress_level" class="form-control" min="1" max="10" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>

            <!-- Image Section -->
            <div class="image-container col-md-6">
                <img src="data:image/jpeg;base64,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" alt="Mental Wellbeing Image">
                <div class="image-overlay">
                    <div class="overlay-text">
                        <a href="/Data_Management_Project/all_mentalwellbeing.php">View All Entries</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include "layout/footer.php"; ?>
