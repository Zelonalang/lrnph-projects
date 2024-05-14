<?php
// Replace these with your own database credentials
$host = 'localhost';
$username = 'itadmin';
$password = 'La.rose1@)@!';
$database = 'lrnphdev';

// Create a connection to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Check for a successful connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the "psize" value from the AJAX request
$psize = $_GET['psize'];

// Prepare and execute a SQL query to retrieve "prate" and "pblispcs" based on "psize"
$query = "SELECT prate, pblispcs FROM tbl_coating WHERE psize = ?";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $psize); // Bind the parameter

    if ($stmt->execute()) {
        $stmt->bind_result($prate, $pblispcs);

        // Fetch the results
        $stmt->fetch();

        // Create an associative array to hold the results
        $result = array(
            'prate' => $prate,
            'pblispcs' => $pblispcs
        );

        // Return the results as JSON
        echo json_encode($result);
    } else {
        echo json_encode(array('error' => 'Query execution failed'));
    }

    $stmt->close();
} else {
    echo json_encode(array('error' => 'Query preparation failed'));
}

$mysqli->close();
?>
