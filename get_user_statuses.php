<?php
// Database connection information
$db_host = 'localhost';
$db_user = 'itadmin';
$db_pass = 'La.rose1@)@!';
$db_name = 'lrnphdev';

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



try {
    // Database connection code here
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve user statuses
    $sql = "SELECT username, online_status FROM sysusers";
    $result = $conn->query($sql);

    $userStatuses = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userStatuses[$row["username"]] = (bool) $row["online_status"];
        }
    }

    // Close the database connection
    $conn->close();

    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Return user statuses as JSON
    echo json_encode($userStatuses);
} catch (Exception $e) {
    // Handle exceptions gracefully
    echo json_encode(["error" => $e->getMessage()]);
}





// SQL query to retrieve user statuses
$sql = "SELECT username, online_status FROM sysusers";
$result = $conn->query($sql);

$userStatuses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userStatuses[$row["username"]] = (bool)$row["online_status"];
    }
}

// Close the database connection
$conn->close();

// Set the response content type to JSON
header('Content-Type: application/json');

// Return user statuses as JSON
echo json_encode($userStatuses);
?>
