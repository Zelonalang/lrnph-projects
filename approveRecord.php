<?php include 'header.php'; ?>


<?php
// Include your database connection code or configuration here

// Check if the "CID" is sent via POST
if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];

    // Perform the database update to mark the record as approved
    // Replace the following code with your actual database update logic

    // Define your database connection parameters (modify as needed)
    $servername = "localhost";
    $username = "itadmin";
    $password = "La.rose1@)@!";
    $dbname = "lrnphdev";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the update query
    $currentDateTime = date('Y-m-d H:i:s'); // Get the current date and time

$updateQuery = "UPDATE pentbl_coating SET actionstatus = 'approved by " . $_SESSION['employeeName'] . "', apremarks = '" . $currentDateTime . "' WHERE cid = ?";


    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("s", $cid);


      $insertQuery = "INSERT INTO `tbl_coating`(`psize`, `pdesc`, `prate`, `pblister`, `pblispcs`, `sunq`, `pshape`) SELECT  `psize`, `pdesc`, `prate`, `pblister`, `pblispcs`, `sunq`, `pshape` FROM `pentbl_coating` WHERE cid = ?";
    $stmtinsert = $conn->prepare($insertQuery);
    $stmtinsert->bind_param("s", $cid);

    if ($stmt->execute() && $stmtinsert->execute()) {
        // Record approved successfully
        echo "Record with CID $cid has been approved.";
    } else {
        // Error handling for the database update
        echo "Error approving the record.";
    }



    // Close the database connection
    $stmt->close();
    $stmtinsert->close();
    $conn->close();
} else {
    // Handle cases where "CID" is not provided in the POST request
    echo "CID not provided in the request.";
}
?>
