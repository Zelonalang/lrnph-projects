

<?php
// Connect to your database (Replace with your database credentials)
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform the SQL query
$query = "SELECT `cid`, `psize`, `pdesc`, `prate`, `pblister`, `pblispcs`, `sunq`, `pshape`, `actionby`, `actionstatus` FROM `pentbl_coating` WHERE actionstatus = 'for approval'";
$result = $conn->query($query);
?>

<script src="auto-update.js"></script>

<table border="1">
    <tr>
        <th hidden>CID</th>
        <th>Size/Shape</th>
        <th>Description</th>
        <th>Rate/Pcs</th>
        <th hidden>Blister</th>
        <th>Pcs/Blister</th>
        <th hidden>Sunq</th>
        <th>Shape Classification</th>
        <th hidden>Action By</th>
        <th hidden>Action Status</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td hidden>" . $row["cid"] . "</td>";
            echo "<td>" . $row["psize"] . "</td>";
            echo "<td>" . $row["pdesc"] . "</td>";
            echo "<td>" . $row["prate"] . "</td>";
            echo "<td hidden>" . $row["pblister"] . "</td>";
            echo "<td>" . $row["pblispcs"] . "</td>";
            echo "<td hidden>" . $row["sunq"] . "</td>";
            echo "<td>" . $row["pshape"] . "</td>";
            echo "<td hidden>" . $row["actionby"] . "</td>";
            echo "<td hidden>" . $row["actionstatus"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No request pending</td></tr>";
    }
    ?>

</table>
    