<?php
// Central settings. Nothing secret lives in this file.
// Put real values in tools/config.local.php (copy config.example.php),
// which is ignored by git, or use environment variables.
function app_config() {
    static $config = null;

    if ($config === null) {
        $pass = getenv('ACTIVEZEN_DB_PASS');
        $config = [
            'db_host'           => getenv('ACTIVEZEN_DB_HOST') ?: '127.0.0.1',
            'db_user'           => getenv('ACTIVEZEN_DB_USER') ?: 'root',
            'db_pass'           => ($pass !== false) ? $pass : '',   // XAMPP default: empty
            'db_name'           => getenv('ACTIVEZEN_DB_NAME') ?: 'activezen',
            'db_port'           => (int) (getenv('ACTIVEZEN_DB_PORT') ?: 3306),
            'admin_access_code' => getenv('ACTIVEZEN_ADMIN_CODE') ?: '', // empty = admin login disabled
        ];

        $local = __DIR__ . '/config.local.php';
        if (is_file($local)) {
            $overrides = require $local;
            if (is_array($overrides)) {
                $config = array_merge($config, $overrides);
            }
        }
    }

    return $config;
}
