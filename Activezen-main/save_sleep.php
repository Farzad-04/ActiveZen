<?php
include "layout/header.php";


if (!isset($_SESSION["User_id"])) {
    // Redirect to login if not authenticated
    header("Location: /Data_Management_Project/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sleep Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2018/01/18/18/36/sleep-3094544_1280.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            position: relative;
        }

        .confirmation-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 100px auto;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            color: #7C0A02; /* Dark red theme */
        }

        .btn {
            background-color: #7C0A02;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #590801;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-container">
            <h2>Sleep Successfully Submitted!</h2>
            <p>Would you like to log another sleep entry?</p>
            <div>
                <a href="sleep.php" class="btn">Yes</a>
                <a href="menu.php" class="btn">No</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php include "layout/footer.php"; ?>
