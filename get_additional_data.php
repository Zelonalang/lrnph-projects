<?php
// Include your database connection file
include 'dbcon.php';

// Check if the 'id' parameter is set and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute a query to retrieve additional data based on the 'id'
    $sql = "SELECT * FROM coatingprod WHERE id = $id";
    $result = $conn->query($sql);

    if ($result) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Create an array with the additional data you want to return
        $additionalData = [
            'biometric' => $row['bionum'],
            // Add other fields as needed
        ];

        // Encode the data as JSON and send it back to the client
        echo json_encode(['modalContent' => json_encode($additionalData)]);

        // Close the database connection
        $conn->close();
        exit;
    } else {
        // Handle query execution error
        echo json_encode(['error' => 'Query failed']);
        $conn->close();
        exit;
    }
} else {
    // Handle invalid or missing 'id' parameter
    echo json_encode(['error' => 'Invalid or missing ID']);
    exit;
}
?>
