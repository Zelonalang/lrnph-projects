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



     button {
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
    }

    /* Style for form elements */
    .form-control {
        width: 98.4%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }


      .form-container {
        max-width: 1700px;
        margin: 0 auto;
          margin-top: 70px;
        padding: 20px;
        background-color: #f0f0f0;
        border-radius: 5px;
    }


 table {
        border-collapse: collapse;
        width: 100%;
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
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:nth-child(odd) {
        background-color: #e0e0e0;
    }
</style>



<div class="form-container">
<!-- Size Form -->




<form id="sizeForm">



    <input type="text" class="form-control" id="actionby" name="actionby" style="color:red" value="<?=$_SESSION['employeeName']?>" readonly hidden>



    <select class="form-control" id="sizeSelector" name="sizeSelector" onchange="toggleFields()">
        <option value="" selected>Select Size</option>
        <option value="large">Large/Extra Large Sizes</option>
        <option value="regular">Regular Sizes</option>
        <option value="medium">Medium Sizes</option>
        <option value="small">Small Sizes</option>
        <option value="xmini">Mini/Extra Mini Sizes</option>
        <option value="uniques">Unique Sizes</option>
    </select>
    <br>
    <span id="selectedValueSpan" hidden></span>

    <select class="form-control" id="result" name="result">
        <option value="" selected>Select Base Size/Shape/Flavor</option>
    </select>
    <br>

    <input type="text" class="form-control" id="csizeField" name="csizeField" placeholder="Size Code" required onchange="clearOtherFields()">
    <label for="displayPrate" style="color:red;"><i>*Update to new coating code</i></label><br>
 

    <input type="text" class="form-control" id="pdescField" name="pdescField" placeholder="Size description" required>
    <label for="displayPrate" style="color:red;"><i>*Add the description of the size/shape/flavor</i></label><br>
 

    <script type="text/javascript">
        function toggleFields() {
            var sizeSelector = document.getElementById("sizeSelector");
            var resultSelect = document.getElementById("result");
            var csizeField = document.getElementById("csizeField");

            // Reset other fields if needed
            // ...

            if (sizeSelector.value !== "") {
                resultSelect.style.display = "block";
                csizeField.style display = "none";
            } else {
                resultSelect.style.display = "none";
                csizeField.style.display = "block";
            }
        }
    </script>

    <label for="displayPrate" ></label>
    <input type="text" class="form-control" id="displayPrate" name="displayPrate" placeholder="Rate/Pcs">
   
    <input type="text" class="form-control" id="displayPblispcs" name="displayPblispcs" placeholder="Pcs/Blister">


    <input type="text" class="form-control" id="sunqField" name="sunqField" placeholder="Sunq" hidden>


     <input type="text" class="form-control" id="actionstatus" name="actionstatus" placeholder="actionstatus" hidden>



    <script>
        // Function to update the csize input field
        function updateCsizeField(value) {
            document.getElementById("csizeField").value = value;

            // Update other fields as needed
            // ...
        }

        // Add an event listener to the csize input field
        var csizeField = document.getElementById("csizeField");
        csizeField.addEventListener("input", function() {
            updateCsizeField(csizeField.value);
        });

      
    </script>
<br>




<!-- <input type="password" class="form-control" id="snpass" name="snpass" placeholder="Enter supervisor's password" style="width:200px;">
 -->
<button type="submit" id="submitWithPassword" style="background-color: green;" >Save New Size/Shape</button>

<!-- <script type="text/javascript">
    // Function to check the "Super Admin" password
    function checkSuperAdminPassword(password) {
        // Make an AJAX request to your server-side script to check the password
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "validateSuperAdminPassword.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Handle the response from the server
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Check the response from the server
                    var response = xhr.responseText;
                    if (response === "correct") {
                        // Password is correct, enable the button
                        document.getElementById("submitWithPassword").disabled = false;
                         submitWithPassword.style.background = "green";
                    } else {
                        // Password is incorrect, disable the button
                        document.getElementById("submitWithPassword").disabled = true;
                        submitWithPassword.style.background = "#DC143C";
                    }
                } else {
                    // Error handling if the request fails
                    alert("Error: " + xhr.status);
                }
            }
        };

        // Send the password to the server
        xhr.send("password=" + password);
    }

    // Add an event listener to the "snpass" input field
    var snpassField = document.getElementById("snpass");
    snpassField.addEventListener("input", function() {
        var password = snpassField.value;
        checkSuperAdminPassword(password);
    });

    // Attach the click event handler to the "Save now" button
    var saveButton = document.getElementById("submitWithPassword");
    saveButton.addEventListener("click", sendInsertQuery);
</script> -->





<script type="text/javascript">
   // Function to send the INSERT query
function sendInsertQuery() {
    // Get the values from the form fields
    var psize = document.getElementById("csizeField").value;
    var pdesc = document.getElementById("pdescField").value;
    var prate = document.getElementById("displayPrate").value;
    var pblispcs = document.getElementById("displayPblispcs").value;
    var pshape = document.getElementById("result").value;
    var sunq = document.getElementById("sunqField").value;
    var actionby = document.getElementById("actionby").value;
    var actionstatus = "created"

    // Create a data object to send to the server
    var data = {
        psize: psize,
        pdesc: pdesc,
        prate: prate,
        pblispcs: pblispcs,
        pshape: pshape,
        sunq: sunq,
        actionby: actionby,
        actionstatus: actionstatus // Add the actionby field
    };

    // Send an AJAX POST request to your first server-side script (newsizescript.php)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "newsizescript.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Handle the response from the server
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Successful response from the first server
         
                // Now, send the data to the second PHP script
                sendToSecondScript(data);
            } else {
                // Error handling if the request fails
                alert("New Size/Shape has been added");
            }
        }
    };

    // Convert the data object to JSON and send it to the first server-side script
    xhr.send(JSON.stringify(data));
}

    // Function to send data to the second PHP script (insertIntoPentblCoating.php)
    function sendToSecondScript(data) {
        // Send an AJAX POST request to the second server-side script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "pentbl.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        // Handle the response from the server
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Successful response from the second server
                    alert("New Size/Shape has been added");
                } else {
                    // Error handling if the request fails
                    alert("New Size/Shape has been added");
                }
            }
        };

        // Convert the data object to JSON and send it to the second server-side script
        xhr.send(JSON.stringify(data));
    }

    // Attach the click event handler to the "Save now" button
    var saveButton = document.getElementById("submitWithPassword");
    saveButton.addEventListener("click", sendInsertQuery);

    /*// Reset the "snpass" input field
    document.getElementById("snpass").value = "";

    // Disable the "Save now" button again if needed
    document.getElementById("submitWithPassword").disabled = true;*/
</script>





   


   
</form>

<script type="text/javascript">
    // Define a mapping of values for the options
    var valueMapping = {
        "large": "large",
        "regular": "regular",
        "small": "small",
        "xmini": "mini",
        "uniques": "unique",
        "medium": "medium"
    };

    function updateSizeSelectorAndSpan(textValue) {
        var sizeSelector = document.getElementById("sizeSelector");
        var selectedValueSpan = document.getElementById("selectedValueSpan");

        var selectedValue = Object.keys(valueMapping).find(function (key) {
            return valueMapping[key] == textValue;
        });

        if (selectedValue !== undefined) {
            sizeSelector.value = selectedValue;
            selectedValueSpan.textContent = textValue;
            updateResultSelect(textValue);
        } else {
            sizeSelector.value = "";
            selectedValueSpan.textContent = "";
            clearResultSelect();
        }
    }

    function updateResultSelect(textValue) {
        var resultSelect = document.getElementById("result");
        resultSelect.innerHTML = '<option value="" selected>Loading...</option>';

        // Use AJAX to fetch options from the server based on the textValue
        // Replace 'ajax_url' with the actual URL of your server-side script
        var ajax_url = 'fetch_options.php';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', ajax_url + '?textValue=' + textValue, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var options = JSON.parse(xhr.responseText);

                resultSelect.innerHTML = '<option value="" selected>Select item code</option>';
                for (var i = 0; i < options.length; i++) {
                    var option = options[i];
                    resultSelect.innerHTML += '<option value="' + option.pshape + '" data-prate="' + option.prate + '" data-pblispcs="' + option.pblispcs + '" data-sunq="' + option.sunq + '">' + option.psize + '</option>';
                }
            } else if (xhr.readyState === 4 && xhr.status !== 200) {
                resultSelect.innerHTML = '<option value="" selected>Error Loading Options</option>';
            }
        };

        xhr.send();
    }

    function clearResultSelect() {
        var resultSelect = document.getElementById("result");
        resultSelect.innerHTML = '<option value="" selected>Select item code</option>';
    }

    var sizeSelector = document.getElementById("sizeSelector");
    sizeSelector.addEventListener("change", function () {
        var selectedValue = sizeSelector.value;
        if (valueMapping[selectedValue] !== undefined) {
            updateSizeSelectorAndSpan(valueMapping[selectedValue]);
        }
    });

    var resultSelect = document.getElementById("result");
    resultSelect.addEventListener("change", function () {
        var selectedOption = resultSelect.options[resultSelect.selectedIndex];
        var selectedText = selectedOption.textContent;
        updateCsizeField(selectedText);
        updateDisplayPrateField(selectedOption.getAttribute("data-prate"));
        updateDisplayPblispcsField(selectedOption.getAttribute("data-pblispcs"));
        updatesunqField(selectedOption.getAttribute("data-sunq"));
    });

    function updateDisplayPrateField(prate) {
        var displayPrate = document.getElementById("displayPrate");
        displayPrate.value = prate;
    }

    function updateDisplayPblispcsField(pblispcs) {
        var displayPblispcs = document.getElementById("displayPblispcs");
        displayPblispcs.value = pblispcs;
    }



     function updatesunqField(sunq) {
        var sunqField = document.getElementById("sunqField");
        sunqField.value = sunq;
    }
</script>



<br>
<?php
// Connect to your database (Replace with your database credentials)
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform the SQL query
$query = "SELECT `cid`, `psize`, `pdesc`, `prate`, `pblister`, `pblispcs`, `sunq`, `pshape`, `actionby`, `actionstatus` FROM `pentbl_coating` WHERE actionstatus = 'for approval'";
$result = $conn->query($query);
?>


<div id="divtable">
<table border="1">
    <tr>
        <th hidden>CID</th>
        <th>Size/Shape</th>
        <th>Description</th>
        <th>Rate/Pcs</th>
        <th hidden>Blister</th>
        <th>Pcs/Blister</th>
        <th hidden>Sunq</th>
        <th>Shape Classification</th>
        <th>Requester</th>
        <th></th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td hidden>" . $row["cid"] . "</td>";
            echo "<td>" . $row["psize"] . "</td>";
            echo "<td>" . $row["pdesc"] . "</td>";
            echo "<td>" . $row["prate"] . "</td>";
            echo "<td hidden>" . $row["pblister"] . "</td>";
            echo "<td>" . $row["pblispcs"] . "</td>";
            echo "<td hidden>" . $row["sunq"] . "</td>";
            echo "<td>" . $row["pshape"] . "</td>";
            echo "<td>" . $row["actionby"] . "</td>";
            echo '<td><button class="approve-button" style="background-color: green;">Approve request</button></td>';
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No request pending</td></tr>";
    }
    ?>

</table>
</div>
</div>


<script type="text/javascript">
    // Add an event listener to all "Approve" buttons in the table
var approveButtons = document.querySelectorAll('.approve-button');
approveButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        // Extract the relevant data from the row associated with the clicked button
        var row = button.closest('tr');
        var cid = row.querySelector('td:first-child').textContent; // Assuming the first column contains the "CID"
         var psize = row.querySelector('td:nth-child(2)').textContent; // Assuming the second column contains the "psize"
        // Send an AJAX request to approve the record
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'approveRecord.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Handle the response from the server, e.g., show a success message
                    alert('Requested size/shape ' + cid + ' has been approved.');
                      // Redirect to sizecreation.php
                window.location.href = "supsizecreation.php";
                } else {
                    // Handle errors
                    alert('Error approving the record.');
                }
            }
        };
        xhr.send('cid=' + cid); // Send the CID to the server
    });
});

</script>