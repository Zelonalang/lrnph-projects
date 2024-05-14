<!-- fetch_users.php -->

<?php
// fetch_users.php

// Replace with your database connection details
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from sysusers table
$sql = "SELECT `userid`, `username`, `password`, `biometricno`, `role`, `online_status`, `avatar_path` FROM `sysusers`";
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);

$conn->close();
?>
