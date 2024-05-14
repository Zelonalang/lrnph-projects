<?php

// Example code (replace with your actual database connection and logic)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection established already
    $servername = "localhost";
    $username = "itadmin";
    $password = "La.rose1@)@!";
    $dbname = "lrnphdev";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the array of IDs to delete
    $idsToDelete = $_POST['ids'];

    // Use proper sanitation before using the IDs in a query to prevent SQL injection
    $sanitizedIds = array_map([$conn, 'real_escape_string'], $idsToDelete);
    $quotedIds = implode("','", $sanitizedIds);

    // Perform the deletion for coatingprod table
    $deleteCoatingQuery = "DELETE FROM coatingprod WHERE id IN ('$quotedIds')";
    if ($conn->query($deleteCoatingQuery) === TRUE) {
        echo "Records in 'coatingprod' table deleted successfully";
    } else {
        echo "Error deleting records from 'coatingprod' table: " . $conn->error;
    }

    // Perform the deletion for allrecorded table
    $deleteAllRecordedQuery = "DELETE FROM allrecorded WHERE id IN ('$quotedIds')";
    if ($conn->query($deleteAllRecordedQuery) === TRUE) {
        echo "Records in 'allrecorded' table deleted successfully";
    } else {
        echo "Error deleting records from 'allrecorded' table: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method";
}

?>
