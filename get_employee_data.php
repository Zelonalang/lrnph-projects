<?php
header('Content-Type: application/json');
$response = array();
if (isset($_GET['sid']))
{
    $con=mysqli_connect("localhost", "itadmin", "La.rose1@)@!", "lrnph");
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $qry = "SELECT Bio, EmployeeName FROM employeeinfo WHERE Bio = '".$_GET['sid']."' ";
    $result = mysqli_query($con, $qry);  //mysql_query($qry);
    while ($row = mysqli_fetch_array($result)) {
        array_push($response, $row);
    }
 
    echo json_encode($response);
} 
?>

 