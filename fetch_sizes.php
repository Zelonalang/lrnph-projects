<?php
// Replace with your database credentials
$host = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a database connection
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to fetch sizes from the database (assuming the table name is "tbl_coating")
$sql = "SELECT DISTINCT psize FROM tbl_coating";

// Execute the query
$result = $connection->query($sql);

if ($result) {
    $sizes = array();

    // Fetch data and store it in an array
    while ($row = $result->fetch_assoc()) {
        $sizes[] = $row['psize'];
    }

    // Close the result and database connection
    $result->close();
    $connection->close();

    // Return the sizes in JSON format
    echo json_encode($sizes);
} else {
    // Handle the query error
    echo "Error: " . $sql . "<br>" . $connection->error;
}

?>
