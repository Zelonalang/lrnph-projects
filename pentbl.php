<?php
// Connect to your database (Replace with your database credentials)
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the AJAX request
$data = json_decode(file_get_contents("php://input"));


// Prepare and execute the INSERT query
$stmt = $conn->prepare("INSERT INTO pentbl_coating (psize, pdesc, prate, pblispcs, pshape, sunq, actionby, actionstatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $data->psize, $data->pdesc, $data->prate, $data->pblispcs, $data->pshape, $data->sunq, $data->actionby, $data->actionstatus);


if ($stmt->execute()) {
    // Insert successful
   /* echo "Data saved successfully!";*/
} else {
    // Error handling if the insert fails
    echo "Error: " . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
