

<?php
include 'dbcon.php';

// Retrieve data from the database
$sql = "SELECT id, bionum, cname, csize, totalpblispcs, coutput, cszrate, clock, rdate, cshiftcode, crecorder, rmdate FROM coatingprod ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>

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

        body {
            font-family: Arial, sans-serif;
        }

      table {
        margin-top: -60px;
    width: 90%;
    border-collapse: collapse;
    border: none; /* Add this line to remove the border */
}

table, th, td {
    border: none; /* Add this line to remove the border */
}

th, td {
    padding: 5px;
    text-align: left;
    font-size: 12px;
}


        th {
            background-color: #85929E;
            
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

         #exportButton.styled-button {
        width: 130px;
        box-sizing: border-box;
        background-color: #85929E;
        color: white;
        border: 1px solid #85929E;
        padding: 10px 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
        text-align: center;
        font-size: 10px;
    }
    </style>
</head>
<body>
<br><br><br>
<br>


    <table border="1" id="dataTable"> <!-- Add the id "dataTable" to the table -->
       <tr> 
            <th hidden>Transaction ID</th>
            <th hidden>Biometric No</th>
            <th hidden>Coater</th>
            <th hidden>Code</th>
             <th hidden>Description</th>
            <th hidden>Total Pcs</th>
            <th hidden>Blister Output</th>
            <th hidden>Total Incentive</th>
            <th hidden>Recorder</th>
            <th hidden>Date & Time</th>
        </tr>
        <?php
        $totalPcsBlister = 0; // Initialize a variable to store the total
        $totalBlister = 0; // Initialize a variable to store the total
        $coaterIncentives = array(); // Associative array to store incentives for each coater

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td hidden>" . $row['id'] . "</td>";
                echo "<td hidden>" . $row['bionum'] . "</td>";
                echo "<td hidden>" . $row['cname'] . "</td>";
                echo "<td hidden>" . $row['csize'] . "</td>";

                // Fetch "pdesc" from "tbl_coating" based on "csize"
                $pdescQuery = "SELECT pdesc FROM tbl_coating WHERE psize = '{$row['csize']}'";
                $pdescResult = $conn->query($pdescQuery);
                $pdescRow = $pdescResult->fetch_assoc();

                // Output "pdesc" column
                echo "<td hidden>" . $pdescRow['pdesc'] . "</td>";

                echo "<td hidden>" . $row['totalpblispcs'] . "</td>";
                echo "<td hidden>" . $row['coutput'] . "</td>";
                echo "<td hidden>" . $row['cszrate'] . "</td>";
                echo "<td hidden>" . $row['crecorder'] .  "</td>";
                echo "<td hidden>" . $row['rmdate'] ." ". $row['clock'] ."</td>";

                echo "</tr>";

                // Add the current row's "Total Pcs/Blister" value to the total
                $totalPcsBlister += $row['totalpblispcs'];

                // Add the current row's "Total Incentive" value to the total
                $totalBlister += $row['coutput'];

                // Add the incentive to the coater's total incentive
                if (!isset($coaterIncentives[$row['cname']])) {
                    $coaterIncentives[$row['cname']] = 0;
                }
                $coaterIncentives[$row['cname']] += $row['cszrate'];
            }
        } else {
            echo "No data available.";
        }
        ?>
        <tr hidden>
            <td colspan="5"></td>
            <td>Total Pcs: <?php echo $totalPcsBlister; ?></td>
            <td>Total Blister: <?php echo $totalBlister; ?></td>
            <td></td> <!-- Empty cell for the total incentive column -->
            <td colspan="4"></td> <!-- Add empty cells for the last columns -->
        </tr>
       <?php
// Output the total incentive for each coater
arsort($coaterIncentives); // Sort the coaters based on incentives in descending order

$count = 0; // Initialize a counter
foreach ($coaterIncentives as $coater => $incentive) {
    echo "<tr>";
    echo "<td>{$coater}</td>";
    echo "<td>{$incentive}</td>";
    echo "</tr>";

    $count++;

    // Break the loop after the top 5 coaters
    if ($count >= 5) {
        break;
    }
}
?>

     </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
  <script>
    function exportToExcel() {
        // Get the table element
        var table = document.getElementById("dataTable");

        // Filter out hidden columns
        var headers = Array.from(table.querySelectorAll("th")).filter(th => th.style.display !== 'none');
        var rows = Array.from(table.querySelectorAll("tr")).map(row =>
            Array.from(row.querySelectorAll("td")).filter(td => td.style.display !== 'none')
        );

        // Create a workbook from the filtered data
        var wb = XLSX.utils.table_to_book(table, { sheet: "DataTable" });

        // Create binary data for the workbook
        var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

        // Function to convert string to ArrayBuffer
        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) {
                view[i] = s.charCodeAt(i) & 0xFF;
            }
            return buf;
        }

        // Save the workbook as Excel file
        saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), "DataTable.xlsx");
    }
</script>


</body>
</html>
