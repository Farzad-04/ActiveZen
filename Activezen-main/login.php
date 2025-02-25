<?php
// Include the header layout for consistent UI
include "layout/header.php";

// If the user is already logged in, redirect to the home page
if (isset($_SESSION["User_id"])) {
    header("location: /Data_Management_Project/Home.php");
    exit;
}

// Initialize variables for user ID and error messages
$user_id = "";
$error = "";

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id']; // Get user ID from form input
    $password = $_POST['password']; // Get password from form input

    // Check if both User ID and Password are provided
    if (empty($user_id) || empty($password)) {
        $error = "User ID and Password are required";
    } else { 
        // Include the database connection utility
        include "tools/db.php";

        // Establish a database connection
        $dbConnection = getDatabaseConnection();

        // Prepare a SQL statement to retrieve user details
        $statement = $dbConnection->prepare(
            "SELECT User_id, Fname, Lname, Username, password, Date_of_birth, Address, Sex FROM user WHERE User_id = ?"
        );
        
        // Bind parameters to the prepared statement
        $statement->bind_param('s', $user_id);
        
        // Execute the prepared statement
        $statement->execute();
        
        // Bind the results to variables
        $statement->bind_result($user_id_result, $first_name, $last_name, $user_name, $stored_password, $date_of_birth, $address, $gender);

        // Check if a user record was found
        if ($statement->fetch()) {
            // Validate the provided password against the stored password
            if ($password == $stored_password)  {
                // Store user information in session variables upon successful login
                $_SESSION["User_id"] = $user_id_result;
                $_SESSION["Fname"] = $first_name;
                $_SESSION["Lname"] = $last_name;
                $_SESSION["Username"] = $user_name;
                $_SESSION["password"] = $password;
                $_SESSION["Date_of_birth"] = $date_of_birth;
                $_SESSION["Address"] = $address;
                $_SESSION["Sex"] = $gender;

                // Redirect to the home page after login
                header("Location: /Data_Management_Project/Home.php");
                exit;
            } else {
                $error = "Invalid password."; // Error if password does not match
            }
        } else {
            $error = "User ID not found."; // Error if no matching user is found
        }

        // Close the prepared statement
        $statement->close();
    }
}
?>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
    }

    .login-container {
        max-width: 400px;
        margin: 100px auto;
        background-color: rgba(255, 255, 255, 0.9);
        border: 2px solid #F5F5DC; /* Beige border */
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
<div class="login-container">
    <h2>Login</h2>

    <!-- Display error messages dynamically -->
    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?= $error ?></strong> <!-- Show the error message -->
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <!-- Dismiss button -->
        </div>
    <?php } ?>

    <!-- User login form -->
    <form method="POST" action="">
        <!-- User ID input field -->
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="text" class="form-control" id="user_id" name="user_id" value="<?= $user_id ?>">
        </div>

        <!-- Password input field -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>

<?php 
// Include the footer layout for consistent UI
include "layout/footer.php";
?>

