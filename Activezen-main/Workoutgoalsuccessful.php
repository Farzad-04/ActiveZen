<?php
include "layout/header.php";
include "tools/db.php"; // Include the db.php file to use the connection function



// Check if the user is logged in
if (!isset($_SESSION["User_id"])) {
    header("location: /Data_Management_Project/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goal Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
   
    .confirmation-page {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 100px); 
        background-color: #f8f9fa;
    }

    .confirmation-container {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 80%;
        max-width: 400px;
        margin: auto;
    }

    .confirmation-container img {
        width: 150px;
        opacity: 0.8; 
        margin-bottom: 20px;
    }

    .confirmation-container h2 {
        color: #28a745; 
        margin-bottom: 15px;
    }

    .confirmation-container p {
        font-size: 18px;
        margin-bottom: 25px;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        border: none;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .btn-yes {
        background-color: #28a745;
        color: white;
    }

    .btn-yes:hover {
        background-color: #218838;
    }

    .btn-no {
        background-color: #dc3545;
        color: white;
    }

    .btn-no:hover {
        background-color: #c82333;
    }
</style>

</head>
<body>
    <div class="confirmation-container">
        <img src="https://thumbs.dreamstime.com/b/green-circle-check-mark-confirmation-tick-okey-marks-accepted-marked-agree-pictogram-success-sign-positive-checked-confirm-125841501.jpg" alt="Success">
        <h2>Goal Submitted Successfully!</h2>
        <p>Would you like to add another goal?</p>
        <div class="btn-container">
            <a href="/Data_Management_Project/workout_goals.php" class="btn btn-yes">Yes</a>
            <a href="/Data_Management_Project/menu.php" class="btn btn-no">No</a>
        </div>
    </div>
</body>
</html>

<?php include "layout/footer.php"; ?>
