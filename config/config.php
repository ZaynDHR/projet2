<?php
// Application Configuration

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bugtracker');

// App Configuration
define('APP_NAME', 'BugTracker');
define('APP_URL', 'http://localhost/projet2');

// Session Configuration
define('SESSION_TIMEOUT', 3600); // 1 hour

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
