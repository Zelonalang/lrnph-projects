<?php

$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create connection
$your_database_connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($your_database_connection->connect_error) {
    die("Connection failed: " . $your_database_connection->connect_error);
}

// Retrieve data from the AJAX request
$id = $_POST['id'];
$coater = $_POST['coater'];
$selectedSize = $_POST['selectedSize'];
$blisterOutput = $_POST['blisterOutput'];
$totalPcs = $_POST['totalPcs'];
$cszrate = $_POST['cszrate'];
$batchNo = $_POST['batchNo'];

// Update the record in the coatingprod table
$queryCoatingProd = "UPDATE coatingprod SET
            cname = '$coater',
            csize = '$selectedSize',
            coutput = '$blisterOutput',
            totalpblispcs = '$totalPcs',
            cszrate = '$cszrate',
            batchno = '$batchNo'
          WHERE id = '$id'";

$resultCoatingProd = $your_database_connection->query($queryCoatingProd);

// Update the record in the allrecorded table
$queryAllRecorded = "UPDATE allrecorded SET
            cname = '$coater',
            csize = '$selectedSize',
            coutput = '$blisterOutput',
            totalpblispcs = '$totalPcs',
            cszrate = '$cszrate',
            batchno = '$batchNo'
          WHERE id = '$id'";

$resultAllRecorded = $your_database_connection->query($queryAllRecorded);

// Insert the record into the corrected_records table
$queryCorrectedRecords = "INSERT INTO corrected_records (id, bionum, cname, cid, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock, rdate, rmdate)
        SELECT * FROM allrecorded WHERE id = '$id'";

$resultCorrectedRecords = $your_database_connection->query($queryCorrectedRecords);

// Check if all operations were successful
if ($resultCoatingProd && $resultAllRecorded && $resultCorrectedRecords) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}

// Close the database connection
$your_database_connection->close();

?>
