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

// Get LRN Code from the query string
$lrnCode = $_GET['lrncode'];

// Fetch Description based on LRN Code
$sql = "SELECT description, pcs_box FROM sproductlist WHERE lrncode = '$lrnCode'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $description = $row['description'];
} else {
    $description = '';
}

$conn->close();

// Return the data as plain text
header('Content-Type: text/plain');
echo $description;
?>
