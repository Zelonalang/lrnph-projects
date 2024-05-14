<?php
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the number of records per page
$recordsPerPage = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default to 10 if not set

// Get the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $recordsPerPage;

// SQL query with LIMIT for paging
$sql = "SELECT `id`, `Bio`, `EmployeeName` FROM coateremployee LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    // Output HTML table with CSS
    echo "<style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
                font-family: Arial, sans-serif;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            button {
                padding: 10px;
                background-color: green;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .paging-links {
                margin-top: 20px;
            }
            .paging-links a {
                margin-right: 5px;
                text-decoration: none;
                padding: 8px;
                background-color: #f2f2f2;
                color: #333;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .paging-links a:hover {
                background-color: #ddd;
            }
            .paging-links .current-page {
                font-weight: bold;
            }
        </style>";
    
    echo "<table id='dataTable'>
            <tr>
                <th>id</th>
                <th>Biometric</th>
                <th>Coater</th>
                
               
               
               
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["Bio"] . "</td>
                <td>" . $row["EmployeeName"] . "</td>
               
              </tr>";
    }

    echo "</table>";

    // Copy to Excel button with CSS
    echo "<div style='margin-top: 20px;'>
            <button onclick='copyToClipboard()'>Copy to Excel</button>
          </div>";

    // Paging links
    $totalRecordsQuery = "SELECT COUNT(*) as total FROM coateremployee";
    $totalResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);

    echo "<div class='paging-links'>";

    // Display page links
    $limitPageLinks = 5; // Number of page links to display
    $startPage = max(1, $currentPage - floor($limitPageLinks / 2));
    $endPage = min($totalPages, $startPage + $limitPageLinks - 1);

    // Ensure the page links do not go below 1 or beyond the total number of pages
    $startPage = max(1, min($startPage, $totalPages - $limitPageLinks + 1));

    // First page link
    if ($startPage > 1) {
        echo "<a href='?page=1&limit=$recordsPerPage'>1</a> ... ";
    }

    // Page links
    for ($i = $startPage; $i <= $endPage; $i++) {
        echo "<a href='?page=$i&limit=$recordsPerPage' class='" . ($i == $currentPage ? "current-page" : "") . "'>$i</a>";
    }

    // Last page link
    if ($endPage < $totalPages) {
        echo "... <a href='?page=$totalPages&limit=$recordsPerPage'>$totalPages</a>";
    }

    // Previous button
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        echo "<a href='?page=$prevPage&limit=$recordsPerPage'>Previous</a>";
    }

    // Next button
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        echo "<a href='?page=$nextPage&limit=$recordsPerPage'>Next</a>";
    }

    // Records per page dropdown
    echo "<span style='margin-left: 20px;'>Records per page: ";
    echo "<select onchange='location = this.value;'>";
    $limitOptions = [20, 50, 100, 500];
    foreach ($limitOptions as $option) {
        echo "<option value='?page=1&limit=$option'";
        if ($recordsPerPage == $option) {
            echo " selected";
        }
        echo ">$option</option>";
    }
    echo "</select></span>";

    echo "</div>";
} else {
    echo "No results found";
}

// Close the connection
$conn->close();
?>

<script>
function copyToClipboard() {
    var table = document.getElementById("dataTable");
    var range = document.createRange();
    range.selectNode(table);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand("copy");
    alert("Table data copied to clipboard!");
    window.getSelection().removeAllRanges();
}
</script>
