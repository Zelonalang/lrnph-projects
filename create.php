<?php
include 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bionum = $_POST['bionum'];
    $cname = $_POST['cname'];
    $cid = $_POST['cid'];
    $csize = $_POST['csize'];
    $prate = $_POST['prate'];
    $cpblister = $_POST['cpblister'];
    $pblispcs = $_POST['pblispcs'];
    $totalpblispcs = $_POST['totalpblispcs'];
    $coutput = $_POST['coutput'];
    $cszrate = $_POST['cszrate'];
    $cshiftcode = $_POST['cshiftcode']; 
    $batchno = $_POST['batchno'];
    $crecorder = $_POST['crecorder'];
    $clock = $_POST['clock'];

    $sql = "INSERT INTO coatingprod (bionum, cname, cid, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock,rmdate)
            VALUES ('$bionum', '$cname', '$cid', '$csize', '$prate', '$cpblister', '$pblispcs', '$totalpblispcs', '$coutput', '$cszrate', '$cshiftcode', '$batchno', '$crecorder', '$clock',now())";

    $sql1 = "INSERT INTO allrecorded (bionum, cname, cid, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock, rmdate)
            VALUES ('$bionum', '$cname', '$cid', '$csize', '$prate', '$cpblister', '$pblispcs', '$totalpblispcs', '$coutput', '$cszrate', '$cshiftcode', '$batchno', '$crecorder', '$clock', now())";

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
