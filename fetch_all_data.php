<?php

// Assuming you have a database connection
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the default table name (replace 'default_table' with your actual default table name)
$defaultTable = "allrecorded";

// Get the table name from the request or use the default
$tableName = isset($_GET['tableName']) ? $_GET['tableName'] : $defaultTable;

// Fetch column names from the specified table
$columnsSql = "SHOW COLUMNS FROM $tableName";
$columnsResult = $conn->query($columnsSql);

$columns = array();

if ($columnsResult) {
    while ($columnRow = $columnsResult->fetch_assoc()) {
        $columns[] = $columnRow['Field'];
    }
} else {
    // Handle query error
    die("Query failed: " . $conn->error);
}

// Fetch all data from the specified table
$dataSql = "SELECT * FROM $tableName";
$dataResult = $conn->query($dataSql);

$data = array();

if ($dataResult) {
    // Fetch data and store it in an array
    while ($row = $dataResult->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    // Handle query error
    die("Query failed: " . $conn->error);
}

// Close the database connection
$conn->close();

// Return the data and columns as JSON
header('Content-Type: application/json');
echo json_encode(['columns' => $columns, 'rows' => $data]);

?>
