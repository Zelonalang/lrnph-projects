<?php
// Establish a database connection (replace with your database credentials)
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['size'])) {
    $selectedSize = $_GET['size'];

    // Replace with your SQL query to retrieve prate and ppblispcs for the selected size
    $sql = "SELECT prate, ppblispcs FROM tbl_coating WHERE size = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedSize);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = array(
            'prate' => $row['prate'],
            'pblispcs' => $row['pblispcs']
        );
        echo json_encode($data);
    } else {
        // Handle the case where data for the selected size is not found
        echo json_encode(null);
    }

    $stmt->close();
}

$conn->close();
?>
