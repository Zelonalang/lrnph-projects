<?php

// Establish a database connection (you may need to adjust these settings)
$host = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform the select query
$sql = "SELECT psize, pdesc, prate, pblispcs, sunq, pshape, actionby, astatus FROM pentbl_coating";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the database connection
    $conn->close();

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // No data found
    echo json_encode(array());
}

?>
