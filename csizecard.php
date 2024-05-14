<?php
// Define the getMiniBarColor function
function getMiniBarColor($count) {
    // Define your logic to determine the mini bar color based on the count
    // For example, you can return different colors based on some conditions.
    if ($count > 10) {
        return 'background-color: green;';
    } else {
        return 'background-color: red;';
    }
}

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

// Execute your SQL query to fetch data
$sql = "SELECT COUNT(coatingprod.bionum) as totalemp
        FROM coatingprod
        INNER JOIN tbl_coating ON coatingprod.csize = tbl_coating.psize   WHERE csize = 'EⓂ' GROUP by  coatingprod.bionum";
$result = $conn->query($sql);

// Initialize max_cname_count to ensure it gets updated
$max_cname_count = 0;

if ($result->num_rows > 0) {
    $countemp = 0;
    // Find the maximum cname_count value
    while ($row = $result->fetch_assoc()) {
        $countemp = $countemp +1;

       
    }
     $max_cname_count = max($max_cname_count, $countemp);

    // Reset the result set pointer to the beginning
    $result->data_seek(0);

    echo '<div style="transform: scale(1);">';

    while ($row = $result->fetch_assoc()) {
        $barWidth = ($row['cname_count'] / $max_cname_count) * 100;

        // Use the getMiniBarColor function to determine the mini bar color
        $miniBarColor = getMiniBarColor($row['cname_count']);

        echo '<div class="bar-container">';
        echo '<span style="font-size:10px;">' . $row['csize'] . '</b></span>';

        $cname_count = $row['cname_count'];
        $cname_countFloat = floatval($countemp);

      echo '<span ><p align="right" style="margin-bottom:-17px; margin-top:-17px; font-size:10px;">' . $cname_countFloat . '</p></span><br>';

        echo '<span class="bar" style="width:' . $barWidth . '%;' . $miniBarColor . '"></span>'; // Apply mini bar color
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No available Records.";
}

// Close the database connection
$conn->close();
?>

<style>
    .bar {
        margin-bottom: 5px;
        display: inline-block;
        height: 4px; /* You can adjust the height as needed */
    }
</style>

<script type="text/javascript">
    
</script>