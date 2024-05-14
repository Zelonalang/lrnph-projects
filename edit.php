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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the edit form
    $editBionum = $_POST["editBionumField"]; 
    $editCname = $_POST["editCnameField"];
    $editCsize = $_POST["editCsizeField"];
    $editCid = $_POST["editCidField"];
    $editTotalpblispcs = $_POST["editTotalpblispcsField"];
 $cpblister = $_POST['cpblister'];
     $editCoutput = $_POST["editCoutputField"];
    $editCszrate = $_POST["editCszrateField"];
    $editBatchno = $_POST["editBatchNoField"];
     $cshiftcode = $_POST['cshiftcode'];
      $displayPrate = $_POST['displayPrate'];
       $displayPblispcs = $_POST['displayPblispcs'];
       $ecrecorderField = $_POST['ecrecorderField'];
        $eclock = $_POST['eclock'];

    // Insert a new record into the database
    $sql = "INSERT INTO coatingprod (bionum, cname, cid, csize, totalpblispcs, cpblister, coutput, cszrate, batchno, cshiftcode, prate, pblispcs, crecorder, clock, rmdate)
            VALUES ('$editBionum', '$editCname','$editCid', '$editCsize', '$editTotalpblispcs', '$cpblister', '$editCoutput', '$editCszrate', '$editBatchno', '$cshiftcode', '$displayPrate', '$displayPblispcs', '$ecrecorderField', '$eclock', now())";


 $sql1 = "INSERT INTO allrecorded (bionum, cname, cid, csize, totalpblispcs, cpblister, coutput, cszrate, batchno, cshiftcode, prate, pblispcs, crecorder, clock, rmdate)
            VALUES ('$editBionum', '$editCname','$editCid', '$editCsize', '$editTotalpblispcs', '$cpblister', '$editCoutput', '$editCszrate', '$editBatchno', '$cshiftcode', '$displayPrate', '$displayPblispcs', '$ecrecorderField', '$eclock', now())";


// Execute the first SQL query
    if ($conn->query($sql) === TRUE) {
        // Execute the second SQL query
        if ($conn->query($sql1) === TRUE) {
            // Redirect to recording.php if both SQL queries are successful
            header("Location: recording.php");
        } else {
            // Handle the case where the second SQL query fails
            echo "Error in second query: " . $sql1 . "<br>" . $conn->error;
        }
    } else {
        // Handle the case where the first SQL query fails
        echo "Error in first query: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>