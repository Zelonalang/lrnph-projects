<?php include 'header.php'; ?>

<?php
include 'dbcon.php';

// Check if filter values are provided
$filterStartDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$filterEndDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$filterStartTime = isset($_POST['start_time']) ? $_POST['start_time'] : '';
$filterEndTime = isset($_POST['end_time']) ? $_POST['end_time'] : '';

// Modify the SQL query to include date and time filters
$sql = "SELECT id, bionum, cname, csize, totalpblispcs, coutput, cszrate, clock, rdate, cshiftcode, crecorder, rmdate FROM allrecorded 
        WHERE (rmdate BETWEEN '$filterStartDate' AND '$filterEndDate') 
        AND (CONCAT(rmdate, ' ', clock) BETWEEN '$filterStartDate $filterStartTime' AND '$filterEndDate $filterEndTime')
        ORDER BY rmdate ASC";
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
            font-size: 1.2rem;
        }

        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        form input {
            margin-right: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form button {
            padding: 5px 10px;
            background-color: #85929E;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #85929E;
            color: white;
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
            font-size: 16px;
        }
    </style>
</head>
<body>
<br><br><br>   
    <br><form method="post" action="">
        &nbsp;&nbsp;<b>Start Date: <input type="date" name="start_date" value="<?php echo $filterStartDate; ?>">
        End Date: <input type="date" name="end_date" value="<?php echo $filterEndDate; ?>">
        Start Time: <input type="time" name="start_time" value="<?php echo $filterStartTime; ?>">
        End Time: <input type="time" name="end_time" value="<?php echo $filterEndTime; ?>">
        <button type="submit">Apply Filter</button></b>&nbsp;<a href='shiftreport.php' class='back-button'>Shift Report</a>
    | <a href='incentivelist.php' class='back-button'>Incentives</a>
    </form>


    <button id="exportButton" class="styled-button" onclick="exportToExcel()">Export</button>


    <table border="1" id="dataTable">
        <tr> 
            <th>Transaction ID</th>
            <th>Biometric No</th>
            <th>Coater</th>
            <th>Code</th>
            <th>Description</th>
            <th>Pcs</th>
            <th>Blister Output</th>
            <th>Total Incentive</th>
            <th>Recorder</th>
            <th>Date & Time</th>
        </tr>
        <?php
        $totalPcsBlister = 0;
        $totalIncentive = 0;
        $totalBlister = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['bionum'] . "</td>";
                echo "<td>" . $row['cname'] . "</td>";
                echo "<td>" . $row['csize'] . "</td>";

                $pdescQuery = "SELECT pdesc FROM tbl_coating WHERE psize = '{$row['csize']}'";
                $pdescResult = $conn->query($pdescQuery);
                $pdescRow = $pdescResult->fetch_assoc();

                echo "<td>" . $pdescRow['pdesc'] . "</td>";
                echo "<td>" . $row['totalpblispcs'] . "</td>";
                echo "<td>" . $row['coutput'] . "</td>";
                echo "<td>" . $row['cszrate'] . "</td>";
                echo "<td>" . $row['crecorder'] . "</td>";
                echo "<td>" . $row['rmdate'] . " " . $row['clock'] . "</td>";

                echo "</tr>";

                $totalPcsBlister += $row['totalpblispcs'];
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
            <td colspan="2"></td>
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
