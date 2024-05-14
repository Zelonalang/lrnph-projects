<?php
// Replace with your actual database credentials
$host = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the psize value from the request
$psize = $_GET['psize'];

// Prepare and execute a SQL query to retrieve data
$query = "SELECT prate, pblispcs FROM tbl_coating WHERE psize = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $psize);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $prate, $pblispcs);

// Fetch the result
if (mysqli_stmt_fetch($stmt)) {
    $data = [
        'prate' => $prate,
        'pblispcs' => $pblispcs,
    ];
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Data not found']);
}

// Close the database connection
mysqli_close($conn);
?>
