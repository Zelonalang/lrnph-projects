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

// Check if the 'id' parameter is set in the POST data
if (isset($_POST['id'])) {
    // Get the 'id' parameter from the POST data
    $recordId = $_POST['id'];
    $actby = $_POST['actby']; // Use the correct syntax to get the value of 'actby' from the $_POST array


    // Query to select the record from coatingprod table before deletion
    $selectCoatingprodQuery = "SELECT * FROM coatingprod WHERE id = '$recordId'";
    $coatingprodResult = $your_database_connection->query($selectCoatingprodQuery);

    // Check if the record exists in coatingprod table
    if ($coatingprodResult->num_rows > 0) {
        // Fetch the record data
        $coatingprodData = $coatingprodResult->fetch_assoc();

        // Query to insert the record into deleted_records table
        $insertDeletedRecordsQuery = "INSERT INTO deleted_records (id, bionum, cname, cid, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock, rdate, rmdate, actby)
        VALUES ('".$coatingprodData['id']."', '".$coatingprodData['bionum']."', '".$coatingprodData['cname']."', '".$coatingprodData['cid']."', '".$coatingprodData['csize']."', '".$coatingprodData['prate']."', '".$coatingprodData['cpblister']."', '".$coatingprodData['pblispcs']."', '".$coatingprodData['totalpblispcs']."', '".$coatingprodData['coutput']."', '".$coatingprodData['cszrate']."', '".$coatingprodData['cshiftcode']."', '".$coatingprodData['batchno']."', '".$coatingprodData['crecorder']."', '".$coatingprodData['clock']."', '".$coatingprodData['rdate']."', '".$coatingprodData['rmdate']."', '".$actby."')";

        // Perform insertion into deleted_records table
        if ($your_database_connection->query($insertDeletedRecordsQuery) === TRUE) {
            // Record inserted successfully into deleted_records table

            // Query to delete the record with the specified ID from coatingprod table
            $coatingprodQuery = "DELETE FROM coatingprod WHERE id = '$recordId'";

            // Query to delete the record with the specified ID from the allrecorded table
            $allrecordedQuery = "DELETE FROM allrecorded WHERE id = '$recordId'";

            // Perform deletion for coatingprod table
            if ($your_database_connection->query($coatingprodQuery) === TRUE) {
                // Record deleted successfully for coatingprod table
                echo json_encode(['status' => 'success']);
            } else {
                // Error deleting record for coatingprod table
                echo json_encode(['status' => 'error', 'message' => 'Error deleting the record from coatingprod table.']);
            }

            // Perform deletion for allrecorded table
            if ($your_database_connection->query($allrecordedQuery) === TRUE) {
                // Record deleted successfully for allrecorded table
                echo json_encode(['status' => 'success']);
            } else {
                // Error deleting record for allrecorded table
                echo json_encode(['status' => 'error', 'message' => 'Error deleting the record from allrecorded table.']);
            }
        } else {
            // Error inserting record into deleted_records table
            echo json_encode(['status' => 'error', 'message' => 'Error inserting the record into deleted_records table.']);
        }
    } else {
        // Record not found in coatingprod table
        echo json_encode(['status' => 'error', 'message' => 'Record not found in coatingprod table.']);
    }
} else {
    // Invalid request. Please provide a valid record ID.
    echo json_encode(['status' => 'error', 'message' => 'Invalid request. Please provide a valid record ID.']);
}

// Close the database connection
$your_database_connection->close();
?>
