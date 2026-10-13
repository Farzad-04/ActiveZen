<?php
// Copy this file to config.local.php and fill in your own values.
// config.local.php is listed in .gitignore, so it is never committed.
return [
    'db_host'           => '127.0.0.1',
    'db_user'           => 'root',
    'db_pass'           => '',          // XAMPP's default root password is empty
    'db_name'           => 'activezen',
    'db_port'           => 3306,        // XAMPP default; MySQL Workbench setups often use 3308
    'admin_access_code' => 'choose-a-long-random-code',
];
