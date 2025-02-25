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
    $height = $_POST['height'];
    $waist_size = $_POST['waist_size'];
    $chest_size = $_POST['chest_size'];
    $hip_size = $_POST['hip_size'];
    $arm_size = $_POST['arm_size'];
    $thigh_size = $_POST['thigh_size'];
    $date = $_POST['date'];

    // Validate the data (basic checks)
    if (empty($height) || empty($waist_size) || empty($chest_size) || empty($hip_size) || empty($arm_size) || empty($thigh_size) || empty($date)) {
        echo "<p class='text-danger'>Please fill in all required fields.</p>";
    } else {
        // Get the logged-in user's ID
        $user_id = $_SESSION["User_id"];

        // Prepare the SQL query to insert the body size data into the database
        $sql = "INSERT INTO BodySize (User_id, Date, Height, Waist_size, Chest_size, Hip_size, Arm_size, Thigh_size) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("issddddd", $user_id, $date, $height, $waist_size, $chest_size, $hip_size, $arm_size, $thigh_size);

            if ($stmt->execute()) {
                // Redirect to the new page after successful data submission
                header("Location: /Data_Management_Project/body_size_success.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "<p class='text-danger'>Failed to save body size data. Please try again.</p>";
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
    <title>Body Size Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://media.istockphoto.com/id/1450995510/vector/fitness-equipment-seamless-pattern-with-kettlebell-dumbbell-and-ab-roller-cartoon-flat.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
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
            text-align: center;
        }

        .image-container img {
            width: 100%;
            border-radius: 50%;
            max-width: 300px;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 140, 186, 0.7);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .image-container:hover .image-overlay {
            opacity: 1;
        }

        .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        .overlay-text a {
            color: white;
            text-decoration: none;
        }

        .overlay-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Track Your Body Size</h2>
                    <form method="POST" action="">
                        <div class="form-group mb-3">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="height">Height (cm)</label>
                            <input type="number" step="0.1" id="height" name="height" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="waist_size">Waist Size (cm)</label>
                            <input type="number" step="0.1" id="waist_size" name="waist_size" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="chest_size">Chest Size (cm)</label>
                            <input type="number" step="0.1" id="chest_size" name="chest_size" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="hip_size">Hip Size (cm)</label>
                            <input type="number" step="0.1" id="hip_size" name="hip_size" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="arm_size">Arm Size (cm)</label>
                            <input type="number" step="0.1" id="arm_size" name="arm_size" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="thigh_size">Thigh Size (cm)</label>
                            <input type="number" step="0.1" id="thigh_size" name="thigh_size" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Body Size</button>
                    </form>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="image-container">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9QRboXzwvbuOJ7l-XfL3YfAcjraS2H-opSQ&s" alt="Goals Image">
                    <div class="image-overlay">
                        <div class="overlay-text">
                            <a href="/Data_Management_Project/user_bodysizes.php">View Stats</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


<?php include "layout/footer.php"; ?>
