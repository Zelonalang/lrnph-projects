<?php
// Define your database connection parameters
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'textValue' parameter is provided in the URL
if (isset($_GET['textValue'])) {
    $textValue = $_GET['textValue'];

    // Sanitize and validate the input to prevent SQL injection
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $textValue)) {
        die("Error: Invalid 'textValue' parameter.");
    }

    // Prepare a SQL query to fetch data based on 'textValue' and include "prate" and "pblispcs"
    $sql = "SELECT cid, pshape, psize, prate, pblispcs, sunq FROM tbl_coating WHERE pshape LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $textValue . '%';
    $stmt->bind_param("s", $searchTerm);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result set
        $result = $stmt->get_result();

        // Fetch the rows as an array
        $filteredData = array();
        while ($row = $result->fetch_assoc()) {
            $filteredData[] = $row;
        }

        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();

        // Return the filtered data as JSON
        header('Content-Type: application/json');
        echo json_encode($filteredData);
    } else {
        // Handle query execution errors
        die("Error: Query execution failed.");
    }
} else {
    // If 'textValue' is not provided, return an error message
    die("Error: 'textValue' parameter is missing.");
}
?>
