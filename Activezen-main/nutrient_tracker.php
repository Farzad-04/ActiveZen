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
    $meal_type = $_POST['meal_type'];
    $calories = $_POST['calories'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $fats = $_POST['fats'];
    $water = $_POST['water'];
    $date_time = $_POST['date_time'];

    // Validate the data
    if (
        is_null($meal_type) || 
        $meal_type === "" || 
        is_null($calories) || 
        is_null($protein) || 
        is_null($carbs) || 
        is_null($fats) || 
        is_null($water) || 
        is_null($date_time) || 
        $date_time === ""
    ) {
        echo "<p class='text-danger'>Please fill in all required fields.</p>";
    } else {
        // Get the logged-in user's ID
        $user_id = $_SESSION["User_id"];

        // Prepare the SQL query to insert the nutrient data into the database
        $sql = "INSERT INTO nutrition_tracker (User_id, Meal_type, Calories, Protein, Carbs, Fats, Water, Date_time) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isiiiiss", $user_id, $meal_type, $calories, $protein, $carbs, $fats, $water, $date_time);

            if ($stmt->execute()) {
                // Redirect to the confirmation page
                header("Location: /Data_Management_Project/save_nutrition.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "<p class='text-danger'>Failed to log nutrition data. Please try again.</p>";
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
    <title>Nutrient Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nutrition-page {
            background-image: url('https://media.istockphoto.com/id/1450995510/vector/fitness-equipment-seamless-pattern-with-kettlebell-dumbbell-and-ab-roller-cartoon-flat.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            position: relative;
            padding: 20px;
        }

        .nutrition-page::before {
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

        .nutrition-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 50px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
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
        }

        .image-container img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 10px;
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
            border-radius: 10px;
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
<body class="nutrition-page">
    <div class="nutrition-container">
        <div class="form-container">
            <h2>Nutrient Tracker</h2>
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="meal_type">Meal Type</label>
                    <select id="meal_type" name="meal_type" class="form-control" required>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Dinner">Dinner</option>
                        <option value="Snack">Snack</option>
                        <option value="Water">Water</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="calories">Calories</label>
                    <input type="number" id="calories" name="calories" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="protein">Protein (g)</label>
                    <input type="number" id="protein" name="protein" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="carbs">Carbs (g)</label>
                    <input type="number" id="carbs" name="carbs" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="fats">Fats (g)</label>
                    <input type="number" id="fats" name="fats" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="water">Water (ml)</label>
                    <input type="number" id="water" name="water" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="date_time">Date & Time</label>
                    <input type="datetime-local" id="date_time" name="date_time" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log Nutrition</button>
            </form>
        </div>

        <div class="image-container">
            <img src="data:image/jpeg;base64,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" alt="Nutrition Image">
            <div class="image-overlay">
                <div class="overlay-text">
                    <a href="/Data_Management_Project/all_nutrition.php">View All Entries</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include "layout/footer.php"; ?>

