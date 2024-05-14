<?php
// Database connection information
$servername = "localhost";
$db_username = "itadmin";
$db_password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create a database connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check for database connection errors (you may want to handle this more gracefully)
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get the action data from the request
$data = json_decode(file_get_contents("php://input"));

// Define the username (you may get this from the session as before)
$username = $_SESSION['username'];

// Insert a record into the audit trail table
$insert_sql = "INSERT INTO audit_trail (username, action) VALUES (?, ?)";
$stmt = $conn->prepare($insert_sql);

if ($stmt) {
    $stmt->bind_param("ss", $username, $data->action);
    if ($stmt->execute()) {
        // Record successfully inserted into the audit trail
        echo "Audit trail record inserted successfully.";
    } else {
        // Handle the insert error
        echo "Error inserting audit trail record: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Handle the prepare statement error
    echo "Prepare statement error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
