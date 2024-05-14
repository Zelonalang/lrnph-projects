<?php include 'header.php'; ?>


<?php


// Establish database connection
$dsn = "mysql:host=localhost;dbname=lrnphdev";
$username = "itadmin";
$password = "La.rose1@)@!";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve data from users table
    $query = "SELECT csize, coutput, totalpblispcs FROM coatingprod";
    $result = $pdo->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    // Process the data for the pie chart
    $csizeData = [];
    $coutputData = [];

    foreach ($data as $row) {
        $csizeData[$row['csize']] = isset($csizeData[$row['csize']]) ? $csizeData[$row['csize']] + 1 : 1;
        $coutputData[$row['coutput']] = isset($coutputData[$row['coutput']]) ? $coutputData[$row['coutput']] + 1 : 1;
    }

    $csizeLabels = array_keys($csizeData);
    $csizeValues = array_values($csizeData);

    $coutputLabels = array_keys($coutputData);
    $coutputValues = array_values($coutputData);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Define an array of colors
$colors = [
    '#FF5733', '#3498DB', '#27AE60', '#F39C12', '#9B59B6',
    '#E74C3C', '#1ABC9C', '#D35400', '#C0392B', '#8E44AD',
    '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5',
    '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50',
    '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800',
    '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#607D8B'
];

// ... (previous code)

// Query to retrieve data from users table including 'cname', 'csize', and 'coutput'
$query = "SELECT totalpblispcs, cname, csize, sum(cszrate) as totalcoutput FROM coatingprod inner join tbl_coating on coatingprod.csize = tbl_coating.psize where tbl_coating.sunq = '111' GROUP BY totalpblispcs, cname, csize ORDER by totalcoutput DESC ";
$result = $pdo->query($query);
$data = $result->fetchAll(PDO::FETCH_ASSOC);

// Process the data for the mini bar graph
$miniBarData = [];

foreach ($data as $row) {
    $cname = $row['cname'];
    $csize = $row['csize'];
    $totalcoutput = $row['totalcoutput'];
    
    if (!isset($miniBarData[$cname])) {
        $miniBarData[$cname] = [];
    }

    $miniBarData[$cname][] = [
        'csize' => $csize,
        'totalcoutput' => $totalcoutput
    ];
}

$miniBarLabels = array_keys($miniBarData);
$miniBarValues = array_values($miniBarData);
$miniBarDatasetLabels = [];
$miniBarCsizeValues = [];
$miniBarCoutputValues = [];

foreach ($miniBarValues as $dataset) {
    $miniBarDatasetLabels[] = $dataset[0]['csize'];
    $miniBarCsizeValues[] = array_column($dataset, 'csize');
    $miniBarCoutputValues[] = array_column($dataset, 'totalcoutput');
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pie Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    .chartmain-container {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #f0f0f0;
        border-radius: 6px;
        font-family: Arial;
        font-size: 18px;
    }

    .chart-container {
        flex: 1;
        height: 400px;
        margin: 10px;
    }
    
    .chart-labels {
        flex: 1;
        text-align: right;
    }

    .minibar-container {
    margin: 10px;
}

.minibar-container {
        position: relative; /* Add this line */
        margin: 10px;
    }

    .minibar-container::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        border-bottom: 1px solid #ccc; /* Adjust the color and style as needed */
    }
</style>

</head>
<body>
    <br><br><br><br>
<div class="chartmain-container">
    <div class="chart-container">
        <b>Blister Record Count</b></br><canvas id="csizeChart" width="400" height="400"></canvas>
    </div>
   
</div>


<div class="chartmain-container">
<!-- Add the mini bar graph container -->
<div class="minibar-container">
 
    <canvas id="minibarChart" width="1150" height="400"></canvas>
</div>
</div>



<script>
    var colors = <?php echo json_encode($colors); ?>;

   function renderCharts(csizeLabels, csizeValues, coutputLabels, coutputValues) {
   // Create and render the pie chart for csize
var csizeChart = new Chart(document.getElementById('csizeChart'), {
    type: 'pie',
    data: {
        labels: csizeLabels,
        datasets: [{
            data: csizeValues,
            backgroundColor: colors.slice(0, csizeLabels.length).map(color => color + '80'), // Adding '66' for 40% opacity
            borderColor: 'black',
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 20,
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});

    // Create and render the pie chart for coutput
    var coutputChart = new Chart(document.getElementById('coutputChart'), {
        type: 'pie',
        data: {
            labels: coutputLabels,
            datasets: [{
                data: coutputValues,
                backgroundColor: colors.slice(csizeLabels.length)
            }]
        },
        options: {
            maintainAspectRatio: false
        }
    });
}


function updateCharts() {
    // Use AJAX to fetch updated data from the server
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_updated_data.php', true); // Update the URL here
    xhr.onload = function() {
        if (xhr.status === 200) {
            var responseData = JSON.parse(xhr.responseText);
            renderCharts(responseData.csizeLabels, responseData.csizeValues, responseData.coutputLabels, responseData.coutputValues);
        }
    };
    xhr.send();
}

// Update charts initially and every 10 seconds
updateCharts();
setInterval(updateCharts, 20000); // 10 seconds










var annotation = {
    type: 'line',
    mode: 'horizontal',
    scaleID: 'y',
    value: 80,
    borderColor: 'rgba(0,0,0,0.3)',
    borderWidth: 5,
    borderDash: [20, 5], // Set the border dash pattern for a dotted line
    label: {
        backgroundColor: 'rgba(255,255,0,0)',
        content: 'Zero Line',
        enabled: true,
        position: 'right'
    }
};


// ... (previous code)

 var minibarChart = new Chart(document.getElementById('minibarChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($miniBarLabels); ?>,
            datasets: [
               
                {
                    label: 'INCENTIVE RATES',
                    data: <?php echo json_encode($miniBarCoutputValues); ?>,
                    backgroundColor: createGradient(colors.slice(0, <?php echo count($miniBarLabels); ?>)),
                    borderWidth: [1, 1, 1, 1], // Only bottom border has width
                    borderColor: 'black',     // Border color
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                    barPercentage: 1.0,
                    categoryPercentage: 0.1
                },
                y: {
                    beginAtZero: true, // Set this to true to start the y-axis at zero
                    stacked: false
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw;
                            return label;
                        }
                    }
                },
                annotation: { // Add this part
                    annotations: [annotation]
                }
            }
        }
    });



// Function to create gradient backgrounds for bar chart datasets
function createGradient(colors) {
    var gradientColors = [];
    for (var i = 0; i < colors.length; i++) {
        var gradient = document.createElement('canvas').getContext('2d').createLinearGradient(5, 10, 200, 1100);
        gradient.addColorStop(0, colors[i]);
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)'); // Adjust the transparency to control shading
        gradientColors.push(gradient);
    }
    return gradientColors;

}
  // Function to reload the page after a delay
    function reloadPage() {
        location.reload();
    }

    // Update charts initially and every 3 seconds
    updateCharts();
    setInterval(updateCharts, 1000000); // 30 seconds

    // Reload the page every 3 seconds
    setInterval(reloadPage, 100000); // 3 seconds
</script>





</body>
</html>
