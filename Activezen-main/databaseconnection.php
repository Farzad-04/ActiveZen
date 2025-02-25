<?php 
$host = "127.0.0.1"; // or your Workbench host
$username = "root"; // or your Workbench username
$password = "Djxbox360@"; // your Workbench password
$database = "activezen"; // your database name
$port = 3308; // default MySQL port (change if different in Workbench)

$connection = mysqli_connect($host, $username, $password, $database, $port);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully to Workbench MySQL server.";

?>

