<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Data</h1>
        <div class="mb-4">
            <label for="user-select" class="form-label">Select a User:</label>
            <select id="user-select" class="form-select">
                <option value="">-- Select User --</option>
                <!-- User options will be dynamically populated -->
            </select>
        </div>

        <h2>Workout Tracker</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="workout-goals-table">
                <thead class="table-dark">
                    <tr>
                        <th>Workout Type</th>
                        <th>Duration (minutes)</th>
                        <th>Calories Burned</th>
                        <th>Date & Time</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Workout goals will be dynamically populated -->
                </tbody>
            </table>
        </div>

        <h2>Nutrition Tracker</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="nutrition-goals-table">
                <thead class="table-dark">
                    <tr>
                        <th>Meal Type</th>
                        <th>Calories</th>
                        <th>Protein (g)</th>
                        <th>Carbs (g)</th>
                        <th>Fats (g)</th>
                        <th>Water (ml)</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Nutrition goals will be dynamically populated -->
                </tbody>
            </table>
        </div>

        <!-- Back to Dashboard Button -->
        <div class="text-center mt-4">
            <a href="/Data_Management_Project/admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>

    <script> 
    // Function to fetch users from the server
    async function fetchUsers() {
        try {
            // Fetching users from the PHP endpoint
            const response = await fetch("/Data_Management_Project/fetch_users.php");
            
            // Check if the response is not successful, throw an error
            if (!response.ok) throw new Error("Failed to fetch users.");

            // Parse the response as JSON
            const users = await response.json();

            // Get the select element where users will be listed
            const userSelect = document.getElementById("user-select");

            // Loop through each user and create an option element for the dropdown
            users.forEach(user => {
                const option = document.createElement("option");
                option.value = user.User_id; // Set the value to user ID
                option.textContent = `${user.Username} (${user.User_id})`; // Display the username and user ID
                userSelect.appendChild(option); // Append the option to the select dropdown
            });
        } catch (error) {
            // Log any error that occurs during the fetch operation
            console.error("Error fetching users:", error);
        }
    }

    // Function to fetch goals for a specific user
    async function fetchGoals(userId) {
        try {
            // Fetch workout goals for the user
            const workoutResponse = await fetch(`/Data_Management_Project/fetch_workout_goals.php?user_id=${userId}`);
            if (!workoutResponse.ok) throw new Error("Failed to fetch workout goals.");
            const workoutGoals = await workoutResponse.json();

            // Display the fetched workout goals in the workout goals table
            displayGoals(workoutGoals, "workout-goals-table", "Workout");

            // Fetch nutrition goals for the user
            const nutritionResponse = await fetch(`/Data_Management_Project/fetch_nutrition_goals.php?user_id=${userId}`);
            if (!nutritionResponse.ok) throw new Error("Failed to fetch nutrition goals.");
            const nutritionGoals = await nutritionResponse.json();

            // Display the fetched nutrition goals in the nutrition goals table
            displayGoals(nutritionGoals, "nutrition-goals-table", "Nutrition");
        } catch (error) {
            // Log any error that occurs during the fetch operation
            console.error("Error fetching goals:", error);
        }
    }

    // Function to display the goals in a specific table
    function displayGoals(goals, tableId, goalType) {
        const tableBody = document.getElementById(tableId).querySelector("tbody"); // Get the tbody of the table
        tableBody.innerHTML = ""; // Clear any existing rows

        // Check if there are no goals
        if (goals.length === 0) {
            // Create a row with a message indicating no goals were found
            const noDataRow = document.createElement("tr");
            const noDataCell = document.createElement("td");
            noDataCell.setAttribute("colspan", goalType === "Workout" ? 5 : 7); // Set colspan based on the goal type
            noDataCell.textContent = `No ${goalType.toLowerCase()} goals found.`; // Display the message
            noDataRow.appendChild(noDataCell);
            tableBody.appendChild(noDataRow); // Append the row to the table body
            return;
        }

        // Loop through each goal and create a table row for it
        goals.forEach(goal => {
            const row = document.createElement("tr");

            // Display workout goals in the row
            if (goalType === "Workout") {
                row.innerHTML = `
                    <td>${goal.Workout_type || "N/A"}</td>
                    <td>${goal.Duration || "N/A"}</td>
                    <td>${goal.Calories_burned || "N/A"}</td>
                    <td>${goal.Date_time || "N/A"}</td>
                    <td>${goal.Notes || "N/A"}</td>
                `;
            } 
            // Display nutrition goals in the row
            else if (goalType === "Nutrition") {
                row.innerHTML = `
                    <td>${goal.Meal_type || "N/A"}</td>
                    <td>${goal.Calories || "N/A"}</td>
                    <td>${goal.Protein || "N/A"}</td>
                    <td>${goal.Carbs || "N/A"}</td>
                    <td>${goal.Fats || "N/A"}</td>
                    <td>${goal.Water || "N/A"}</td>
                    <td>${goal.Date_time || "N/A"}</td>
                `;
            }

            // Append the created row to the table body
            tableBody.appendChild(row);
        });
    }

    // Add an event listener to the user select dropdown
    // When the user selects a different user, fetch their goals
    document.getElementById("user-select").addEventListener("change", (event) => {
        const userId = event.target.value; // Get the selected user ID
        if (userId) {
            fetchGoals(userId); // Fetch and display the goals for the selected user
        } else {
            // Clear the tables if no user is selected
            document.getElementById("workout-goals-table").querySelector("tbody").innerHTML = "";
            document.getElementById("nutrition-goals-table").querySelector("tbody").innerHTML = "";
        }
    });

    // Fetch the list of users when the page loads
    fetchUsers();
</script>
