<?php 
// Function to establish a database connection
function getDatabaseConnection() {
    // Database connection details
    $servername = "127.0.0.1";  // Server address
    $username = "root";         // Database username
    $password = "Djxbox360@";   // Database password
    $database = "activezen";    // Database name
    $port = 3308;               // MySQL port number

    // Create a new connection using MySQLi
    $connection = new mysqli($servername, $username, $password, $database, $port);
    
    // Check if the connection failed
    if($connection->connect_error){
        die("Error: Failed to connect to MySQL: " . $connection->connect_error);
    }

    // Return the connection object
    return $connection;
}
?>
