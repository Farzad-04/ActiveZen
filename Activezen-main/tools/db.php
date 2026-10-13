<?php
require_once __DIR__ . '/config.php';

// Function to establish a database connection
function getDatabaseConnection() {
    $config = app_config();

    // Report problems through return values (the pages check for them) instead of exceptions
    mysqli_report(MYSQLI_REPORT_OFF);

    $connection = new mysqli(
        $config['db_host'],
        $config['db_user'],
        $config['db_pass'],
        $config['db_name'],
        $config['db_port']
    );

    if ($connection->connect_error) {
        // Details go to the server log, not to the visitor's screen
        error_log('ActiveZen database connection failed: ' . $connection->connect_error);
        die('Could not connect to the database. Make sure MySQL is running and the settings in tools/config.local.php are correct.');
    }

    $connection->set_charset('utf8mb4');

    return $connection;
}
?>
