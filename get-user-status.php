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

// SQL query to fetch user statuses
$sql = "SELECT `userid`, `online_status` FROM `sysusers`";
$result = $conn->query($sql);

if ($result) {
    $userStatus = array();

    while ($row = $result->fetch_assoc()) {
        $userStatus[] = array(
            'userid' => $row['userid'],
            'online_status' => $row['online_status']
        );
    }

    // Close the database connection
    $conn->close();

    // Return user statuses as JSON
    header('Content-Type: application/json');
    echo json_encode($userStatus);
} else {
    echo "Error fetching user statuses";
}

?>
