

<?php include 'header.php'; ?>
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
                title: 'Pie Chart',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    <style type="text/css">

        
        
    header {
        background-color: rgba(51, 51, 51, 0.8);
        color: #fff;
        padding: 10px;
        display: flex;
        align-items: center;
        backdrop-filter: blur(5px);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;

         font-size: 1.2rem; /* Responsive font size for the header */
    }


    </style>
</head>
<body>
    
    <div id="piechart" style="width: 1910px; height: 920px;"></div>

</body>
</html>
