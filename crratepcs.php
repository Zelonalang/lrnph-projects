<?php

// Database credentials
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create connection
$your_database_connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($your_database_connection->connect_error) {
    // Return an error message if the connection fails
    echo json_encode(['error' => 'Connection failed: ' . $your_database_connection->connect_error]);
    exit(); // Terminate script execution
}

// Check if the action is to get_prate
if (isset($_POST['action']) && $_POST['action'] === 'get_prate') {
    // Get the selected psize from the POST data
    $selectedPsize = $_POST['psize'];

    // Query to fetch prate and pblispcs based on the selected psize
    $query = "SELECT prate, pblispcs FROM tbl_coating WHERE psize = '$selectedPsize'";
    
    // Execute the query
    $result = $your_database_connection->query($query);

    // Check if the query was successful
    if ($result !== false && $result->num_rows > 0) {
        // Fetch the prate and pblispcs values
        $row = $result->fetch_assoc();
        $prate = $row['prate'];
        $pblispcs = $row['pblispcs'];
 
        // Return prate and pblispcs as JSON
        echo json_encode(['prate' => $prate, 'pblispcs' => $pblispcs]);
    } else {
        // Return an error message if the query fails
        echo json_encode(['error' => 'Error fetching values from the server.']);
    }
} else {
    // Return an error message if the action is not set or invalid
    echo json_encode(['error' => 'Invalid action.']);
}

// Close the database connection
$your_database_connection->close();
?>
                                                                                                                                                                     