


<?php
// Include the header.php file if needed
// include 'header.php';


// Database connection parameters
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute the SQL query
$sql = "SELECT csize, sum(totalpblispcs) as totalcoutput FROM coatingprod inner join tbl_coating on coatingprod.csize = tbl_coating.psize where tbl_coating.sunq = '111' GROUP BY csize ORDER by totalcoutput DESC";
$result = $conn->query($sql);

// Prepare data for the pie chart
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = [$row['csize'], (float)$row['totalcoutput']];
}

// Close the database connection
$conn->close();

// Convert data to JSON
$data_json = json_encode($data);

// Create a pie chart using Google Charts
?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Category');
            data.addColumn('number', 'Value');
            data.addRows(<?php echo $data_json; ?>);

            var options = {
                title: '',
                is3D: true,
                backgroundColor: 'transparent',
                chartArea: { 'width': '80%', 'height': '80%', 'left': '1%', 'top': '1%' }, // Adjust width and height
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    <style type="text/css">
        /* Add any custom styles you need here */
    </style>
</head>
<body>
    <div id="piechart" style="width: 382px; height: 184px;"></div>
</body>
</html>

