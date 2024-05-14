<?php
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch LRN Codes, Descriptions, and pcs_box from the sproductlist table
$sql = "SELECT lrncode, description, pcs_box FROM sproductlist";
$result = $conn->query($sql);

$lrnCodes = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lrnCodes[] = array(
            'lrncode' => $row['lrncode'],
            'description' => $row['description'],
            'pcs_box' => $row['pcs_box']
        );
    }
}

$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($lrnCodes);
?>
