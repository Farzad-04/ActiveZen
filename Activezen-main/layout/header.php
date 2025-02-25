<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check if the user or admin is authenticated
$user_authenticated = isset($_SESSION["User_id"]);
$admin_authenticated = isset($_SESSION["Admin_id"]); // Assuming admin session is stored in Admin_id
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Active Zen</title>
    <link rel="icon" href="images/Logo.jpg">
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link to CSS file -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="images/Logo.jpg" width="30" height="30" class="d-inline-block align-top" alt=""> Active Zen
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHome" aria-controls="navbarHome" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarHome">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-white" href="/Data_Management_Project/home.php">Home</a>
            </li>

            <?php if ($user_authenticated): ?>   <!--Check if the user is authenticated. If true, hide the buttons -->
              <!-- Menu Link for Logged-in Users -->
              <li class="nav-item">
                <a class="nav-link text-white" href="/Data_Management_Project/menu.php">Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="/Data_Management_Project/tutorial.php">Tutorial</a>
              </li>
            <?php endif; ?>
          </ul>

          <ul class="navbar-nav">
            <?php if ($user_authenticated): ?> <!--Check if the user is authenticated. If true, hide the buttons -->
              <!-- User Dropdown for Logged-in Users -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  User
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/Data_Management_Project/profile.php">Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/Data_Management_Project/logout.php">Logout</a></li>
                </ul>
              </li>
            <?php elseif ($admin_authenticated): ?> <!--Check if the user is authenticated. If true, hide the buttons -->
              <!-- Admin Buttons for Logged-in Admin -->
              <li class="nav-item">
                <a href="/Data_Management_Project/admin_logout.php" class="btn btn-danger me-2">Logout</a>
              </li>
              <li class="nav-item">
                <a href="/Data_Management_Project/user_data.php" class="btn btn-info">User Data</a>
              </li>
            <?php else: ?>
              <!-- Login/Register for Guests -->
              <li class="nav-item">
                <a href="/Data_Management_Project/register.php" class="btn btn-outline-light me-2">Register</a>
              </li>
              <li class="nav-item">
                <a href="/Data_Management_Project/login.php" class="btn btn-light">Login</a>
              </li>
              <!-- Admin Login Button -->
              <li class="nav-item">
                <a href="/Data_Management_Project/admin_login.php" class="btn btn-warning ms-2">Admin</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </body>
</html>
