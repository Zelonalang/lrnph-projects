<?php
// Assuming you have a MySQLi connection established
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

// SQL query with a JOIN
$sql = "SELECT su.`userid`, su.`username`, su.`password`, su.`biometricno`, su.`role`, su.`online_status`, su.`avatar_path`, ei.`EmployeeName`
        FROM `sysusers` su
        JOIN `employeeinfo` ei ON su.`biometricno` = ei.`Bio`
        WHERE su.`online_status` = 'Logged In' 
          AND su.`role` IN ('Coating Supervisor', 'Coating Recorder')";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch associative array
    while ($row = $result->fetch_assoc()) {
        // Output or process each row as needed
        echo '<span style="font-size: 12px;">🟢&nbsp;' . $row['EmployeeName'] . '</span><br>';
        // Add additional fields as needed
    }

    // Free result set
    $result->free();
} else {
    // If the query was not successful, handle the error
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
