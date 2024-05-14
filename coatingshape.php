<?php
header('Content-Type: application/json');
$response = array();
if (isset($_GET['coatid']))
{
  $con=mysqli_connect("localhost", "itadmin", "La.rose1@)@!", "lrnphdev");
  if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  $qry = "SELECT cid, psize, prate, pblispcs, pblister, pdesc, sunq, pshape, pskey FROM tbl_coating WHERE psize = '".$_GET['coatid']."' ";
  $result = mysqli_query($con, $qry);  //mysql_query($qry);
  while ($row = mysqli_fetch_array($result)) {
    array_push($response, $row);
    }

  echo json_encode($response);
} 
?>

