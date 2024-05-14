<?php
// Replace these with your database connection details
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a userId is provided in the query parameter
if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];

    // SQL query to fetch user data by user ID
    $sql = "SELECT `userid`, `username`, `password`, `biometricno`, `role`, `online_status`, `avatar_path` FROM `sysusers` WHERE `userid` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();

        // Return user data as JSON
        header("Content-Type: application/json");
        echo json_encode($userData);
    } else {
        // Handle the error
        echo "Error fetching user data: " . $stmt->error;
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
$conn->close();
?>
