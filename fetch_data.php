<?php

// Connect to the database
$mysqli = new mysqli("localhost", "itadmin", "La.rose1@)@!", "lrnphdev");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get values from the AJAX request
$tableName = isset($_POST['tableName']) ? $_POST['tableName'] : 'allrecorded';

// Build the SELECT query dynamically based on the table structure
$query = "SELECT ";

// Get the columns from the specified table
$columnsQuery = $mysqli->query("SHOW COLUMNS FROM $tableName");

if ($columnsQuery) {
    $columns = $columnsQuery->fetch_all(MYSQLI_ASSOC);

    // Construct the list of columns
    $columnList = array_map(function ($column) {
        return $column['Field'];
    }, $columns);

    // Join the columns to form the SELECT query
    $query .= implode(', ', $columnList);

    // Append the FROM clause
    $query .= " FROM $tableName";

    // Execute the query
    $result = $mysqli->query($query);

    // Fetch the result as an associative array
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        // Handle query error
        die("Query failed: " . $mysqli->error);
    }
} else {
    // Handle query error
    die("Query failed: " . $mysqli->error);
}

// Close the connection
$mysqli->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

?>
