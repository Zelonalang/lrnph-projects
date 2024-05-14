<?php
// Database configuration constants
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'itadmin');
define('DB_PASSWORD', 'La.rose1@)@!');
define('DB_NAME', 'lrnphdev');

// Create a database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
