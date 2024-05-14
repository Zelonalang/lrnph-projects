<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $psize = $_POST['psize'];
    $prate = $_POST['prate'];
    $pblispcs = $_POST['pblispcs'];
    $pblister = $_POST['pblister'];
    $pdesc = $_POST['pdesc'];
    $sunq = $_POST['sunq'];
    $pshape = $_POST['pshape'];
    $pskey = $_POST['pskey'];

    $con = mysqli_connect("localhost", "itadmin", "La.rose1@)@!", "lrnphdev");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $qry = "INSERT INTO tbl_coating (psize, prate, pblispcs, pblister, pdesc, sunq, pshape, pskey) 
            VALUES ('$psize', '$prate', '$pblispcs', '$pblister', '$pdesc', '$sunq', '$pshape', '$pskey')";

    if (mysqli_query($con, $qry)) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
