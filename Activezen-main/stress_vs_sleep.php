<?php
include "layout/header.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["User_id"])) {
    header("Location: /Data_Management_Project/login.php");
    exit;
}

include "tools/db.php";

// Connect to the database
$conn = getDatabaseConnection();

// Get the User_id from the session
$user_id = $_SESSION["User_id"];

// Fetch data from the `stressvsleep` view
$query = "SELECT Record_Date, Entry_Type, StressOrSleepLevel 
          FROM stressvssleep 
          WHERE ID = ?"; // Use 'ID' as per the view definition
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data as an associative array
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stress vs Sleep</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .main-container {
            padding: 20px;
            margin: 0 auto;
            max-width: 1200px;
            text-align: center;
        }

        .chart-container {
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        canvas {
            width: 100%;
            height: auto;
        }

        footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h1>Stress vs Sleep Visualization</h1>
        <div class="chart-container">
            <canvas id="stressSleepChart"></canvas>
        </div>
    </div>

    <script>
        // Prepare the PHP data for JavaScript
        const data = <?php echo json_encode($data); ?>;

        // Process the data for Chart.js
        const labels = [...new Set(data.map(entry => entry.Record_Date))]; // Unique dates
        const stressLevels = data
            .filter(entry => entry.Entry_Type === "Stress")
            .map(entry => entry.StressOrSleepLevel);
        const sleepHours = data
            .filter(entry => entry.Entry_Type === "Sleep")
            .map(entry => entry.StressOrSleepLevel);

        // Create the chart
        const ctx = document.getElementById("stressSleepChart").getContext("2d");
        new Chart(ctx, {
            type: "line", // Line chart
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Stress Level",
                        data: stressLevels,
                        borderColor: "red",
                        backgroundColor: "rgba(255, 0, 0, 0.2)",
                        fill: true,
                        tension: 0.4, // Smooth curves
                    },
                    {
                        label: "Sleep Hours",
                        data: sleepHours,
                        borderColor: "blue",
                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                        fill: true,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Stress vs Sleep Over Time",
                    },
                    tooltip: {
                        mode: "index",
                        intersect: false,
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Date",
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Levels",
                        },
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
</body>
</html>

<?php include "layout/footer.php"; ?>
