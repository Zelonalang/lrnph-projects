<?php
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT `cid`, `psize`, `pdesc`, `prate`, `pblister`, `pblispcs`, `sunq`, `pshape`, `actionby`, `actionstatus` FROM `pentbl_coating` WHERE actionstatus = 'for approval'";
$result = $conn->query($query);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>
