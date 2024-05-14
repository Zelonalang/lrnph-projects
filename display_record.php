<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table Styling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }


        p {
            color: #555;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
&nbsp;<a href='sales_management.php' class='back-button' style="display: inline-block;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;">← Back</a>&nbsp;<a href="#"><img id="infoImage" src="images/edit.png" alt="Info" style="width: 25px; height: 25px;" ></a>
<?php
// Check if the PO number is provided in the query parameter
if (isset($_GET['po_number'])) {
    // Retrieve the PO number from the query parameter
    $po_number = $_GET['po_number'];

    // Your database connection logic here (replace these placeholders)
    $servername = "localhost";
    $username = "itadmin";
    $password = "La.rose1@)@!";
    $dbname = "lrnphdev";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query
    $sql = "SELECT * FROM scontainer WHERE po_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $po_number);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Display records in a data table
    if ($result->num_rows > 0) {
        echo "<h2>PO Number: " . htmlspecialchars($po_number) . "</h2>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th hidden>ID</th>";
        echo "<th>LRN Code</th>";
        echo "<th>Description</th>";
        echo "<th>Box Order</th>";
        echo "<th>Used Pallets on 40ft Container</th>";
        echo "<th>Used Pallets 20ft Container</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $totalBoxOrder = 0;
        $totalUp17mx = 0;
        $totalUp8mx = 0;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td hidden>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['lrn_code']) . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td>" . htmlspecialchars($row['box_order']) . "</td>";
            echo "<td>" . htmlspecialchars($row['up17mx']) . "</td>";
            echo "<td>" . htmlspecialchars($row['up8mx']) . "</td>";
            echo "</tr>";

            // Update totals
            $totalBoxOrder += $row['box_order'];
            $totalUp17mx += $row['up17mx'];
            $totalUp8mx += $row['up8mx'];
        }

        echo "</tbody>";
        echo "<tfoot>";
        echo "<tr>";
        echo "<th colspan='2'>Total</th>";
        echo "<th>" . $totalBoxOrder . "</th>";
        echo "<th>" . $totalUp17mx . "</th>";
        echo "<th>" . $totalUp8mx . "</th>";
        echo "</tr>";
        echo "</tfoot>";
        echo "</table>";
    } else {
        echo "No records found for PO number: " . htmlspecialchars($po_number);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "PO number not provided";
}
?>

</body>
</html>
