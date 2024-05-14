

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
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: gray;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: black;
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
        font-size: 16px;
    }
    </style>
</head>
<body>
<br>

<button id="exportButton" class="styled-button" onclick="exportToExcel()">Excel</button> &nbsp;<a href='alldata.php' class='back-button'>All Records</a>

    <table border="1" id="dataTable"> <!-- Add the id "dataTable" to the table -->
       <tr> 
            <th >Transaction ID</th>
            <th>Biometric No</th>
            <th>Coater</th>
            <th>Code</th>
             <th>Description</th>

            <th>Total Pcs</th>
            <th>Blister Output</th>
            <th>Total Incentive</th>
            <th>Recorder</th>
            <th >Date & Time</th>
       <!--      <th >Date</th> -->
           <!--  <th hidden>Recorder</th> -->
        </tr>
        <?php
        $totalPcsBlister = 0; // Initialize a variable to store the total
        $totalIncentive = 0; // Initialize a variable to store the total
         $totalBlister = 0; // Initialize a variable to store the total


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td >" . $row['id'] . "</td>";
                echo "<td>" . $row['bionum'] . "</td>";
                echo "<td>" . $row['cname'] . "</td>";
                echo "<td>" . $row['csize'] . "</td>";

                
                  // Fetch "pdesc" from "tbl_coating" based on "csize"
                $pdescQuery = "SELECT pdesc FROM tbl_coating WHERE psize = '{$row['csize']}'";
                $pdescResult = $conn->query($pdescQuery);
                $pdescRow = $pdescResult->fetch_assoc();

                // Output "pdesc" column
                echo "<td>" . $pdescRow['pdesc'] . "</td>";

                echo "<td>" . $row['totalpblispcs'] . "</td>";
                echo "<td>" . $row['coutput'] . "</td>";
                echo "<td>" . $row['cszrate'] . "</td>";
                echo "<td>" . $row['crecorder'] .  "</td>";
                echo "<td >" . $row['rmdate'] ." ". $row['clock'] ."</td>";
                /*echo "<td >" . $row['rmdate'] . "</td>";*/
              /*  echo "<td hidden>" . $row['crecorder'] . "</td>";*/

                echo "</tr>";







                // Add the current row's "Total Pcs/Blister" value to the total
                $totalPcsBlister += $row['totalpblispcs'];

                // Add the current row's "Total Incentive" value to the total
                $totalIncentive += $row['cszrate'];
                 $totalBlister += $row['coutput'];
            }
        } else {
            echo "No data available.";
        }
        ?>
        <tr>
            <td colspan="5"></td>
            <td>Total Pcs: <?php echo $totalPcsBlister; ?></td>
            <td>Total Blister: <?php echo $totalBlister; ?></td>
            <td>Total Incentive: <?php echo $totalIncentive; ?></td>
            <td colspan="4"></td> 

    <!-- Add empty cell for the last column -->
        </tr>
     </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            var wb = XLSX.utils.table_to_book(document.getElementById("dataTable"), { sheet: "DataTable" });
            var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

            function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i = 0; i < s.length; i++) {
                    view[i] = s.charCodeAt(i) & 0xFF;
                }
                return buf;
            }

            saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), "DataTable.xlsx");
        }
    </script>
</body>
</html>
