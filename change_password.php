<?php
session_start();

// Your session variables
$username = $_SESSION['username'];

// Your database credentials
$servername = "localhost";
$username_db = "itadmin";
$password_db = "La.rose1@)@!";
$database = "lrnphdev";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the new password from the POST data
if (isset($_POST['newPassword'])) {
    $newPassword = $_POST['newPassword'];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $updateQuery = "UPDATE sysusers SET password = '$hashedPassword' WHERE username = '$username'";

    if ($conn->query($updateQuery) === TRUE) {
        // Password updated successfully
        echo 'success';
    } else {
        // Error updating password
        echo 'error: ' . $conn->error;
    }
} else {
    // No new password provided
    echo 'error: No new password provided';
}

// Close the database connection
$conn->close();
?>
