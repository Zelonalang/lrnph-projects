<?php
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the SQL query from the POST data
if(isset($_POST['query'])){
    $sql = $_POST['query'];

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_data.csv"');
        $output = fopen('php://output', 'w');

        // Output column headers
        $firstRow = $result->fetch_assoc();
        fputcsv($output, array_keys($firstRow));

        // Output data
        fputcsv($output, $firstRow);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        // Close the output file
        fclose($output);
    } else {
        echo "No results found";
    }
} else {
    echo "Invalid request";
}

// Close the connection
$conn->close();
?>
