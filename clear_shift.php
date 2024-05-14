<?php
// Replace with your actual database connection details
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to move records from "coatingprod" to "cleared_table"
$sqlMove = "INSERT INTO cleared_table (id, bionum, cname, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock, rdate) SELECT id, bionum, cname, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock, rdate FROM coatingprod";

// Execute the move query
if ($conn->query($sqlMove) === TRUE) {
    // Include 'recording.php' file after the successful move
    echo "";
} else {
    echo "Error moving records: " . $conn->error;
}

// SQL query to clear records from the "coatingprod" table
$sqlClear = "DELETE FROM coatingprod";

// Execute the clear query
if ($conn->query($sqlClear) === TRUE) {
    echo "Shift for recording have been cleared successfully, reload the page.";
} else {
    echo "Error clearing records: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
