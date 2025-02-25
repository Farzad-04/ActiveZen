<?php  
// Include the header layout file
include "layout/header.php";

// Redirect the user to the home page if they are already logged in
if (isset($_SESSION["User_id"])){
    header("location: /Data_Management_Project/Home.php");
    exit;
}

// Initialize variables for form fields and error messages
$first_name = "";
$last_name = "";
$user_name = "";
$user_id = "";
$email = "";
$address = "";
$date_of_birth = "";

$first_name_error = "";
$last_name_error = "";
$user_name_error = "";
$user_id_error = "";
$email_error = "";
$address_error = "";
$gender_error = "";
$date_of_birth_error = "";
$password_error = "";
$confrim_password_error = "";
$error = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Retrieve form values
    $first_name = $_POST['first_Name']; 
    $last_name = $_POST['last_name']; 
    $user_name = $_POST['user_name']; 
    $user_id = $_POST['user_id']; 
    $email = $_POST['email']; 
    $address = $_POST['address']; 
    $gender = isset($_POST['gender']) ? $_POST['gender'] : ""; 
    $date_of_birth = $_POST['dob']; 
    $password = $_POST['pass']; 
    $confrim_password = $_POST['re_pass']; 

    // Validate first name
    if (empty($first_name)){
        $first_name_error = "First name is required";
        $error = true;
    }

    // Validate last name
    if (empty($last_name)){
        $last_name_error = "Last name is required";
        $error = true;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_error = "Email format is not valid";
        $error = true;
    }

    // Include the database connection file
    include "tools/db.php";

    // Establish the database connection
    $dbConnection = getDatabaseConnection();

    // Check if the User ID is already taken
    $query = "SELECT User_id FROM user WHERE user_id = ?";
    $statement = $dbConnection->prepare($query);

    if ($statement) {
        $statement->bind_param("s", $user_id);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $user_id_error = "User ID is already used";
            $error = true;
        }

        $statement->close();
    } else {
        die("Error preparing SQL statement: " . $dbConnection->error);
    }

    // Check if the Username is already taken
    $query = "SELECT Username FROM user WHERE Username = ?";
    $statement = $dbConnection->prepare($query);

    if ($statement) {
        $statement->bind_param("s", $user_name);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $user_name_error = "Username is already taken";
            $error = true;
        }

        $statement->close();
    } else {
        die("Error preparing SQL statement: " . $dbConnection->error);
    }

    // Validate password length
    if (strlen($password) < 6){
        $password_error = "Password must have at least 6 characters";
        $error = true;
    }

    // Check if password and confirmation password match
    if ($confrim_password != $password){
        $confrim_password_error = "Password and repeat password do not match";
        $error = true;
    }

    // Validate user name
    if (empty($user_name)){
        $user_name_error = "User name is required";
        $error = true;
    }

    // Validate user ID
    if (empty($user_id)){
        $user_id_error = "User ID is required";
        $error = true;
    }

    // Validate gender selection
    if (empty($gender)){
        $gender_error = "Gender selection is required";
        $error = true;
    }

    // Validate date of birth
    if (empty($date_of_birth)) {
        $date_of_birth_error = "Date of birth is required";
        $error = true;
    }

    // If no errors, insert the user into the database
    if (!$error) {
        $statement = $dbConnection->prepare(
            "INSERT INTO user (User_id, Fname, Lname, Username, password, Email, Date_of_birth, Address, Sex) " .
            "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $statement->bind_param('sssssssss', $user_id, $first_name, $last_name, $user_name, $password, $email, $date_of_birth, $address, $gender);
        $statement->execute();
        $statement->close();

        // Set session variables for the logged-in user
        $_SESSION["User_id"] = $user_id;
        $_SESSION["Fname"] = $first_name;
        $_SESSION["Lname"] = $last_name;
        $_SESSION["Username"] = $user_name;
        $_SESSION["password"] = $password;
        $_SESSION["Email"] = $email;
        $_SESSION["Date_of_birth"] = $date_of_birth;
        $_SESSION["Address"] = $address;
        $_SESSION["Sex"] = $gender;

        // Redirect to the home page
        header("Location: /Data_Management_Project/Home.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Forum</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="/Data_Management_Project/style.css">
</head>
<body>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign Up</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="first name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="first_Name" id="First name" placeholder="First Name" />
                                <span class="text-danger"><?= $first_name_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="last name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="last_name" id="last name" placeholder="Last Name" />
                                <span class="text-danger"><?= $last_name_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="user name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="user_name" id="user name" placeholder="User Name" />
                                <span class="text-danger"><?= $user_name_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="user id"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="user_id" id="user id" placeholder="User ID" />
                                <span class="text-danger"><?= $user_id_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" />
                                <span class="text-danger"><?= $email_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-email"></i></label>
                                <input type="text" name="address" id="address" placeholder="Address"/>
                                <span class="text-danger"><?= $address_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="gender"><i class="zmdi zmdi-male-female"></i></label>
                                <select name="gender" id="gender">
                                    <option value="" disabled selected>Select Gender*</option>
                                    <option value="male" <?= isset($gender) && $gender == "male" ? "selected" : "" ?>>Male</option>
                                    <option value="female" <?= isset($gender) && $gender == "female" ? "selected" : "" ?>>Female</option>
                                    <option value="other" <?= isset($gender) && $gender == "other" ? "selected" : "" ?>>Other</option>
                                </select>
                                <span class="text-danger"><?= $gender_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="dob"><i class="zmdi zmdi-calendar"></i></label>
                                <input type="date" name="dob" id="dob" placeholder="Date of Birth" value="<?= htmlspecialchars($date_of_birth) ?>" />
                                <span class="text-danger"><?= $date_of_birth_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" />
                                <span class="text-danger"><?= $password_error ?></span>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your Password" />
                                <span class="text-danger"><?= $confrim_password_error ?></span>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="button" name="signup" id="signup" class="form-submit" value="Cancel" onclick="goToHomepage()"/>
                            </div>
                            <script>
                                function goToHomepage() {
                                    window.location.href = '/Data_Management_Project/Home.php';
                                }
                            </script>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/logo.jpg" alt=""></figure>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>

<?php 
include "layout/footer.php";
?>
