<?php include 'header.php'; ?>

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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px; /* Adjust the margin to account for the fixed header */
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

     input {
        width: 100%;
        box-sizing: border-box;
        padding: 8px; /* Adjust the padding as needed */
        margin: 0;
        border: none;
        border-radius: 4px;
        background-color: #f2f2f2; /* Match the background color of table headers */
    }

    input:focus {
        outline: none;
        border: 1px solid #ddd; /* Highlight the input when focused */
    }


    /* Style the dropdown arrow */
select {
    appearance: none; /* Remove default arrow in Firefox */
    -webkit-appearance: none; /* Remove default arrow in Chrome and Safari */
    -moz-appearance: none; /* Remove default arrow in Firefox */
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f2f2f2;
}

/* Style the options */
select option {
    background-color: #fff;
    color: #333;
}

/* Style the options on hover */
select option:hover {
    background-color: #f5f5f5;
}

/* Style the selected option */
select option:checked {
    background-color: #e0e0e0;
}


 /* Style for the "Save changes" button */
    .save-button {
        background-color: #4CAF50; /* Green background color */
        color: white; /* White text color */
        padding: 10px 15px; /* Padding for better appearance */
        border: none; /* No border */
        border-radius: 4px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
        font-size: 1rem; /* Font size */
    }

    /* Hover effect for the button */
    .save-button:hover {
        background-color: #45a049; /* Darker green on hover */
    }

/* Style for the "Save changes" button */
    .delete-button {
        background-color: red; /* Green background color */
        color: white; /* White text color */
        padding: 10px 15px; /* Padding for better appearance */
        border: none; /* No border */
        border-radius: 4px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
        font-size: 1rem; /* Font size */
    }

 .delete-selected {
        background-color: red; /* Green background color */
        color: white; /* White text color */
        padding: 2px 5px; /* Padding for better appearance */
        border: none; /* No border */
        border-radius: 4px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
        font-size: 1rem; /* Font size */
    }


     .userdiv {
                   position: relative;
                   margin-top: 68px;
                   margin-left: 0.5%;
                   margin-right: 0.5%;
                   padding: 20px; /* Add your desired padding */
                   background-color: #f5f5f5; /* Add your desired background color */
                   border: 10px solid #ccc; /* Add your desired border style */
                   border-radius: 5px; /* Add border radius if needed */
                   display: flex;
                   flex-direction: column;
                   align-items: flex-start; /* Align content to the left */
               }



                .back-button {
        display: inline-block;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .back-button:hover {
        background-color: #45a049;
    }



/* Add this CSS for inline display of action buttons and checkbox */
.action-buttons-container {
    display: flex;
    align-items: center;
}

.save-button,
.delete-button,
input[type="checkbox"] {

    margin-right: 10px; /* Adjust the margin as needed */
}




/* Add this CSS for inline display of action buttons header */
.action-buttons-header {
    display: flex;
    align-items: center;
}

.delete-selected {
    margin-left: 10px; /* Adjust the margin as needed */
}


</style>





 <div class="userdiv">




<input type="text" name="actby" id="actby" value="<?php echo $employeeName; ?>" hidden>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
        const table = document.querySelector('table');

        table.addEventListener('click', function (event) {
            const target = event.target;
            const isCoutputCell = target.tagName === 'TD' && target.cellIndex === 3; // 6 is the index of the 'coutput' cell

            if (isCoutputCell) {
                // Create an input element
                const input = document.createElement('input');
                input.type = 'text';
                input.value = target.textContent.trim();

                // Replace the content of the clicked cell with the input element
                target.innerHTML = '';
                target.appendChild(input);

                // Focus on the input element
                input.focus();

                // Add an event listener to handle the input change
                input.addEventListener('blur', function () {
                    // Update the content of the cell with the input value
                    target.textContent = input.value;

                    // Remove the input element
                    target.removeChild(input);
                });
            }
        });

    // Add event listener for change event on select elements with name 'psize'
    const psizeSelects = document.querySelectorAll('select[name="psize"]');
    psizeSelects.forEach(function (select) {
        select.addEventListener('change', function () {
        const selectedPsize = select.value;
        const row = select.closest('tr');

        // Clear the values in the remaining cells
        const totalpblispcsCell = row.querySelector('td:nth-child(9)');
        const coutputCell = row.querySelector('td:nth-child(4)');
        const cszrateCell = row.querySelector('td:nth-child(10)');
        const batchnoCell = row.querySelector('td:nth-child(11)');

        // Make an AJAX request to fetch values from the server
        $.ajax({
            type: 'POST',
            url: 'crratepcs.php', // Replace with the actual URL of your PHP script
            data: { action: 'get_prate', psize: selectedPsize },
            dataType: 'json',
            success: function (response) {
                // Update the values in the 'prate' and 'pblispcs' cells based on the server response
                const prateCell = row.querySelector('td:nth-child(7)');
                const pblispcsCell = row.querySelector('td:nth-child(8)');

                prateCell.textContent = response.prate;
                pblispcsCell.textContent = response.pblispcs;

                // Calculate totalpblispcs based on prate and coutput
                const pblispcs = parseFloat(response.pblispcs); // Convert to float to ensure proper multiplication
                const coutput = parseFloat(coutputCell.textContent.trim()); // Convert to float

                // Set the value of totalpblispcsCell as the product of prate and coutput
                totalpblispcsCell.textContent = (isNaN(pblispcs) || isNaN(coutput)) ? '0' : (pblispcs * coutput);

                // Calculate cszrate based on totalpblispcs and prate
                const totalpblispcs = parseFloat(totalpblispcsCell.textContent.trim()); // Convert to float
                const prate = parseFloat(prateCell.textContent.trim()); // Convert to float

                cszrateCell.textContent = (isNaN(totalpblispcs) || isNaN(prate)) ? '0' : (totalpblispcs * prate);
            },
            error: function () {
                alert('Error fetching values from the server.');
            }
        });
    });
});






    });




        function hideSaveButton() {
            const saveButton = document.querySelector('#saveButton');
            saveButton.style.display = 'none';
        }

        function showSaveButton() {
            const saveButton = document.querySelector('#saveButton');
            saveButton.style.display = 'block';
        }

   function saveRecord(button) {
    // Get the closest table row (tr) from the clicked button
    const row = button.closest('tr');

    // Extract relevant data from the row
    const id = row.querySelector('td:nth-child(1)').textContent.trim();
    const coater = row.querySelector('td:nth-child(3)').textContent.trim();
    const selectedSize = row.querySelector('select[name="psize"]').value;
    const blisterOutput = row.querySelector('td:nth-child(8)').textContent.trim();
    const totalPcs = row.querySelector('td:nth-child(9)').textContent.trim();
    const cszrate = row.querySelector('td:nth-child(10)').textContent.trim();
    const batchNo = row.querySelector('input[name="batchno"]').value.trim();
    const rmdate = row.querySelector('td:nth-child(12)').textContent.trim();
    const previousCSize = row.querySelector('input[name="previouscsize"]').value.trim(); // Added previousCSize

    // Make an AJAX request to update the record
    $.ajax({
        type: 'POST',
        url: 'update_record.php', // Replace with the actual URL of your PHP script
        data: {
    id: id,
    coater: coater,
    selectedSize: selectedSize,
    blisterOutput: blisterOutput,
    totalPcs: totalPcs,
    cszrate: cszrate,
    batchNo: batchNo,
    rmdate: rmdate,
    previousCSize: previousCSize, // Added previousCSize
    actby: $('#actby').val() // Include the value of delby
},

        success: function (response) {
            alert('Record updated successfully!');
        },
        error: function () {
            alert('Error updating the record.');
        }
    });
}





 function deleteRecord(button) {
    // Get the closest table row (tr) from the clicked button
    const row = button.closest('tr');

    // Extract relevant data from the row
    const id = row.querySelector('td:nth-child(1)').textContent.trim();

    // Make an AJAX request to delete the record
    $.ajax({
        type: 'POST',
        url: 'delete_record.php', // Replace with the actual URL of your PHP script for deleting records
        data: {
            id: id,
            actby: $('#actby').val() // Include the value of delby
        },
        success: function (response) {
            alert('Record deleted successfully!');
            // Optionally, you can remove the row from the table upon successful deletion
            row.remove();
        },
        error: function () {
            alert('Error deleting the record.');
        }
    });
}


   
</script>







<?php

// Function to fetch all "psize" values from the "tbl_coating" table
function getAllPSizeOptions($your_database_connection) {
    $psizeOptions = array();

    // Query to fetch all distinct "psize" values from the "tbl_coating" table
    $psizeQuery = "SELECT DISTINCT psize FROM tbl_coating";
    $psizeResult = $your_database_connection->query($psizeQuery);

    // Check if the query was successful
    if ($psizeResult !== false && $psizeResult->num_rows > 0) {
        while ($row = $psizeResult->fetch_assoc()) {
            // Add each "psize" value to the options array
            $psizeOptions[] = $row['psize'];
        }
    }

    return $psizeOptions;
}

// Function to get prate based on the selected psize
function getPrateByPSize($your_database_connection, $selectedPsize) {
    $prate = null;

    // Query to fetch prate based on the selected psize
    $query = "SELECT prate FROM tbl_coating WHERE psize = '$selectedPsize'";
    $result = $your_database_connection->query($query);

    // Check if the query was successful
    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prate = $row['prate'];
    }

    return $prate;
}

$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create connection
$your_database_connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($your_database_connection->connect_error) {
    die("Connection failed: " . $your_database_connection->connect_error);
}

  // Check if the 'bionum' parameter is set in the URL
    if (isset($_GET['bionum'])) {
        // Get the 'bionum' parameter from the URL
        $recordBionum = $_GET['bionum'];

        // Query the database to get all records from the coatingprod table
        $query = "SELECT id, bionum, cname, csize, prate, cpblister, pblispcs, totalpblispcs, coutput, cszrate, cshiftcode, batchno, crecorder, clock, rdate, rmdate FROM coatingprod WHERE bionum = '$recordBionum' ORDER BY rdate DESC";
        $result = $your_database_connection->query($query);

        // Check if the query was successful
        if ($result !== false && $result->num_rows > 0) {
            // Fetch the first row to get the value of cname
            $row = $result->fetch_assoc();

            // Display the value of cname
            echo "<a href='recording.php' class='back-button'>← Back</a>";
            echo "<span>Records of <b>{$row['cname']}</b></span>"; 

            // Display the data in a table with specified headers
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th hidden>ID</th>";
            echo "<th hidden>Biometric No</th>";
            echo "<th hidden>Coater</th>";
            echo "<th>Blister Output</th>";
            echo "<th hidden>C Size</th>";
            
            echo "<th>Size</th>";
            echo "<th >Pcs/Rate</th>";
            echo "<th >Pcs/Blister</th>";
            echo "<th>Total Pcs</th>";
            echo "<th>Total Incentive</th>";
            echo "<th>Batch No</th>";
             echo "<th>Recorder</th>";
             echo "<th>Date & Time</th>";
             echo "<th hidden>P Size</th>";
       
echo "<th class='action-buttons-header'>Action";
echo "<button class='delete-selected' onclick='deleteSelectedRecords()' hidden>Delete Records</button>";
echo "</th>";


            echo "</tr>";

          
            // Variable to store the sum of "Total Incentive"
$totalIncentiveSum = 0;

// Display data rows
do {
    // Extract the value from the "Total Incentive" cell
    $totalIncentive = floatval($row['cszrate']); // Convert to float if needed

    // Add the value to the sum
    $totalIncentiveSum += $totalIncentive;





    echo "<tr>";
    echo "<td hidden>{$row['id']}</td>";
    echo "<td hidden>{$row['bionum']}</td>";
    echo "<td hidden>{$row['cname']}</td>";
    echo "<td disabled>{$row['coutput']}</td>";
    echo "<td hidden>{$row['csize']}</td>";

  



    echo "<td style='idth:20px;'>";
    echo "<select name='psize'>";

    // Call the function to get all "psize" options
    $psizeOptions = getAllPSizeOptions($your_database_connection);

    // Display options in the select field
    foreach ($psizeOptions as $psizeOption) {
        // Check if the current option matches the "Csize" for this row
        $selected = ($psizeOption == $row['csize']) ? 'selected' : '';

        echo "<option value='$psizeOption' $selected>$psizeOption</option>";
    }

    echo "</select>";
    echo "</td>";

    echo "<td >{$row['prate']}</td>";
    echo "<td >{$row['pblispcs']}</td>";
    echo "<td>{$row['totalpblispcs']}</td>";
    echo "<td>{$row['cszrate']}</td>";

    // Replace the batch number cell with an input field
    echo "<td>";
    echo "<input type='text' name='batchno' value='{$row['batchno']}' />";
    echo "</td>";

    echo "<td>{$row['crecorder']}</td>";
    echo "<td>{$row['rdate']}</td>";



      echo "<td hidden>";
echo "<input type='text' name='previouscsize' value='prev shape:{$row['csize']}' />";
echo "</td>";



  echo "<td>";
echo "<div class='action-buttons-container'>";
echo "<button class='save-button' onclick='saveRecord(this)'>Save</button>";
echo "<button class='delete-button' onclick='deleteRecord(this)'>Delete</button>";
echo "<input type='checkbox' name='deleteCheckbox[]' value='{$row['id']}'>";
echo "</div>";
echo "</td>";
   
    echo "</td>";

    echo "</tr>";
} while ($row = $result->fetch_assoc());



    // Display the total sum
echo "<tr>";
echo "<td colspan='5'></td>"; // Colspan to span across the columns
echo "<td><b>Total Incentives: $totalIncentiveSum</b></td>";
echo "<td colspan='4'></td>"; // Colspan to span across the columns
echo "</tr>";




echo "</table>";
        } else {
            echo "No records found.";
        }
} else {
    echo "Invalid request. Please provide a valid record ID.";
}

// Close the database connection
$your_database_connection->close();
?>
 <button class="delete-selected" onclick="deleteSelectedRecords()" hidden>Delete Selected</button>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.querySelector('table');
            const deleteButton = document.querySelector('.delete-selected');

            // Add event listener for change event on checkboxes
            const checkboxes = document.querySelectorAll('input[name="deleteCheckbox[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    // Check if any checkbox is checked and update the visibility of the Delete button
                    const anyCheckboxChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                    if (anyCheckboxChecked) {


                        showDeleteButton();
                    } else {
                        hideDeleteButton();
                    }
                });
            });

            table.addEventListener('click', function (event) {
                const target = event.target;
                const isCoutputCell = target.tagName === 'TD' && target.cellIndex === 3; // 6 is the index of the 'coutput' cell

                if (isCoutputCell) {
                    // Create an input element
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = target.textContent.trim();

                    // Replace the content of the clicked cell with the input element
                    target.innerHTML = '';
                    target.appendChild(input);

                    // Focus on the input element
                    input.focus();

                    // Add an event listener to handle the input change
                    input.addEventListener('blur', function () {
                        // Update the content of the cell with the input value
                        target.textContent = input.value;

                        // Remove the input element
                        target.removeChild(input);
                    });
                }
            });

           

            // Function to hide the "Delete Selected" button
            function hideDeleteButton() {
                deleteButton.style.display = 'none';
            }

            // Function to show the "Delete Selected" button
            function showDeleteButton() {
                deleteButton.style.display = 'block';
            }

 
        });

        // Function to handle the delete button click
      function deleteSelectedRecords() {
    const checkboxes = document.querySelectorAll('input[name="deleteCheckbox[]"]:checked');
    const idsToDelete = Array.from(checkboxes).map(checkbox => checkbox.value);

    if (idsToDelete.length === 0) {
        alert('Please select records to delete.');
        return;
    }

    // Make an AJAX request to delete the selected records
    $.ajax({
        type: 'POST',
        url: 'delete_selected_records.php', // Replace with the actual URL of your PHP script for deleting selected records
        data: {
            ids: idsToDelete
        },
        success: function (response) {
            alert('Selected records deleted successfully!');
            // Optionally, you can reload the page or update the UI as needed
            location.reload();
        },
        error: function () {
            alert('Error deleting the selected records.');
        }
    });
}

    </script>
</div>




