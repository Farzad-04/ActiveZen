<?php
// Start a session to manage user authentication
session_start();

// Include the header layout file
include "layout/header.php";

// Redirect to the admin dashboard if already logged in as admin
if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true) {
    header("Location: /Data_Management_Project/admin_dashboard.php");
    exit;
}

// Initialize variables for admin ID and error messages
$admin_id = "";
$error = "";
$special_admin_password = "Activezen"; // Predefined Admin Access Code

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $password = $_POST['password'];
    $admin_password = $_POST['admin_password'];

    // Validate input fields
    if (empty($admin_id) || empty($password) || empty($admin_password)) {
        $error = "Admin ID, Password, and Admin Access Code are required.";
    } elseif ($admin_password !== $special_admin_password) {
        $error = "Invalid Admin Access Code.";
    } else {
        // Include the database connection file
        include "tools/db.php";

        // Get a database connection
        $dbConnection = getDatabaseConnection();

        // Prepare a query to fetch admin details
        $statement = $dbConnection->prepare(
            "SELECT Admin_id, Username, Password, Email, Sex, Date_of_birth, Address FROM admin WHERE Admin_id = ?"
        );

        // Bind parameters for the query
        $statement->bind_param('s', $admin_id);

        // Execute the statement
        $statement->execute();

        // Bind result variables
        $statement->bind_result($admin_id_result, $username, $stored_password, $email, $sex, $dob, $address);

        // Check if the admin ID exists and validate the password
        if ($statement->fetch()) {
            if ($password === $stored_password) {
                // Set session variables upon successful login
                $_SESSION["is_admin"] = true; // Mark the session as admin
                $_SESSION["Admin_id"] = $admin_id_result;
                $_SESSION["Username"] = $username;
                $_SESSION["Email"] = $email;
                $_SESSION["Sex"] = $sex;
                $_SESSION["Date_of_birth"] = $dob;
                $_SESSION["Address"] = $address;

                // Redirect to the admin dashboard
                header("Location: /Data_Management_Project/admin_dashboard.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Admin ID not found.";
        }

        // Close the statement
        $statement->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Link to the Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling used for the admin login page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border: 2px solid #F5F5DC;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            box-shadow: none;
            margin-bottom: 20px;
            padding: 8px;
        }

        .form-control:focus {
            border-bottom: 2px solid #007bff;
            outline: none;
            box-shadow: none;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border: none;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>

    <!-- Display error messages, if any -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?= htmlspecialchars($error) ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Login form -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="admin_id">Admin ID</label>
            <input type="text" class="form-control" id="admin_id" name="admin_id" value="<?= htmlspecialchars($admin_id) ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="admin_password">Admin Access Code</label>
            <input type="password" class="form-control" id="admin_password" name="admin_password">
        </div>

        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>
</body>
</html>

<?php 
// Include the footer layout file
include "layout/footer.php"; 
?>
