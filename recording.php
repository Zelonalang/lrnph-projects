<?php include 'header.php'; ?>

<?php
// Establish a database connection (replace with your database credentials)
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$dbname = "lrnphdev";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute your SQL query to fetch data (replace with your query)
$sql = "SELECT bionum, cid, MAX(prate) as prate, MAX(pblispcs) as pblispcs, 
       MAX(batchno) as batchno, cname, csize, 
       SUM(totalpblispcs) as totalpblispcs, 
       SUM(coutput) as coutput, 
       SUM(cszrate) as cszrate 
FROM coatingprod 
GROUP BY bionum, cname, csize, cid
ORDER BY MAX(rdate) DESC
LIMIT 0, 100;

";
$result = $conn->query($sql);

?>



<?php
$hostname = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$databaseName = "lrnphdev";

$connect = mysqli_connect($hostname, $username, $password, $databaseName);

$query = "SELECT cid, psize, pdesc, prate, pblister, pblispcs, sunq, pshape FROM `tbl_coating`";

$result1 = mysqli_query($connect, $query);

$result2 = mysqli_query($connect, $query);

$options = "";

while ($row2 = mysqli_fetch_array($result2)) {
    $options = $options . "<option>$row2[1]</option>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <link href="recording.css" rel="stylesheet" crossorigin="anonymous">

       <style type="text/css">
       

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
 
    #button-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Add CSS for the buttons inside the container */
    #openAddModal.styled-button {
        width: 130px;
        box-sizing: border-box;
        background-color: #85929E;
        color: white;
        border: 1px solid #85929E;
        padding: 10px 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        text-align: center;
        font-size: 16px;
    }


     #openEditModal.styled-button {
        width: 90px;
        box-sizing: border-box;
        background-color: #85929E;
        color: white;
        border: 1px solid #85929E;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        text-align: center;
        font-size: 16px;
    }


     #NewSize.styled-button {
        width: 130px;
        box-sizing: border-box;
        background-color: #85929E;
        color: white;
        border: 1px solid #85929E;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 140px;
        text-align: center;
        font-size: 16px;
    }



    #clearShift.styled-button {
        width: 140px;
        box-sizing: border-box;
        background-color: #85929E; /* Blue background color */
        color: white; /* White text color */
        border: 1px solid #85929E; /* Blue border */
        padding: 10px 20px; /* Padding around text */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
        margin-right: 1px; /* Add margin to the right of the buttons */
        text-align: center; /* Center text within the button */
        font-size: 16px; /* Adjust the font size */
        align-self: flex-end; /* Align the button to the bottom of the container */
    }



     #ShiftReport.styled-button {
        width: 150px;
        box-sizing: border-box;
        background-color: #85929E; /* Blue background color */
        color: white; /* White text color */
        border: 1px solid #85929E; /* Blue border */
        padding: 10px 20px; /* Padding around text */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
        margin-right: 150px; /* Add margin to the right of the buttons */
        text-align: center; /* Center text within the button */
        font-size: 16px; /* Adjust the font size */
        align-self: flex-end; /* Align the button to the bottom of the container */
    }

    #openAddModal.styled-button:hover,
    #clearShift.styled-button:hover,
     #ShiftReport.styled-button:hover,
     #NewSize.styled-button:hover {
        background-color: gray; /* Darker blue on hover */
        border: 1px solid gray; /* Darker border on hover */
    }

    /* Optional: Add some margin to separate the buttons vertically */
    #clearShift.styled-button {
        margin-top: 1px;
    }


     #ShiftReport.styled-button {
        margin-top: -40px;
    }

     #NewSize.styled-button {
        margin-top: -20px;
    }


     .green-button {
        background-color: green;
        color: white;
        width: 100px;
        box-sizing: border-box;
      
        border: 1px solid #85929E; /* Blue border */
        padding: 10px 20px; /* Padding around text */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
       
        text-align: center; /* Center text within the button */
        font-size: 16px; /* Adjust the font size */
        align-self: flex-end;
        /* Add any additional styling as needed */
    }
 

#liveSearch {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
    width: 400px; /* Adjust the width as needed */
}

#liveSearch:focus {
    outline: none;
    border-color: #85929E; /* Change the border color when focused */
}





    </style>

</head>
<body>

   <div id="content">

     
            <button id="openAddModal" class="styled-button">Add Record</button><br>
             <button id="NewSize" class="styled-button" onclick="redirectTonewsize()">New Size</button>
                
           <button id="clearShift" class="styled-button" onclick="confirmClearShift()">Clear Shift</button>

 <!-- HTML for the modal -->


<script>
    var countdownInterval;

    function confirmClearShift() {
        // Show a confirmation dialog
        var confirmation = confirm("Are you sure you want to clear the shift?");

        // If user clicks "OK" in the confirmation dialog
        if (confirmation) {
            var countdown = 30; // 3 seconds

            // Function to update the countdown text
            function updateCountdownText() {
                document.getElementById("countdownText").innerText = "Clearing shift in " + formatTime(countdown);
            }

            // Function to clear the shift and close the modal
            function clearShiftAndCloseModal() {
                clearShift();
                closeModal();
            }

            // Function to close the modal
            function closeModal() {
                document.getElementById("countdownModal").style.display = "none";
                clearInterval(countdownInterval);
            }

            // Function to cancel clearing and close the modal
            window.cancelClearing = function() {
                clearInterval(countdownInterval);
                closeModal();
            };

            // Show the modal
            document.getElementById("countdownModal").style.display = "block";

            // Start the initial countdown
            updateCountdownText();
            countdownInterval = setInterval(function () {
                countdown--;

                // If countdown reaches 0, clear the shift and close the modal
                if (countdown <= 0) {
                    clearShiftAndCloseModal();
                } else {
                    // Update the countdown text
                    updateCountdownText();
                }
            }, 1000); // 1 second interval
        }
        // If user clicks "Cancel" in the confirmation dialog, do nothing
    }

    // Helper function to format time (convert seconds to MM:SS format)
    function formatTime(seconds) {
        var minutes = Math.floor(seconds / 60);
        var remainingSeconds = seconds % 60;
        return (minutes < 10 ? "0" : "") + minutes + ":" + (remainingSeconds < 10 ? "0" : "") + remainingSeconds;
    }
</script>





                 <button id="ShiftReport" class="styled-button" onclick="redirectToshiftreport()">Shift Report</button>
           
     <br>


<div id="countdownModal" style="display: none;">
    <p id="countdownText"></p>
    <button style="color:red" onclick="cancelClearing()">Cancel</button>
</div>


     <input type="text" id="liveSearch" placeholder="Search...">
        <script>
   function redirectToshiftreport() {
      
      window.location.href = 'shiftreport.php';
   }


 /*  function redirectTonewsize() {
     
      window.location.href = 'sizecreation.php';
       window.location.href = 'sizecreation.php';
   }
*/


function redirectTonewsize() {
  var user_role = "<?php echo $user_role; ?>"; // Get the user_role from PHP

  if (user_role === "Coating Supervisor") {
    window.location.href = 'supsizecreation.php';
  } else if (user_role === "Coating Recorder") {
    window.location.href = 'sizecreation.php';
  } else {
    // Default action if the role doesn't match any of the specified roles
    // You can add a fallback URL or handle it as needed
  }
}


 // Add an event listener to the liveSearch input field
        $('#liveSearch').on('input', function () {
            var searchText = $(this).val().toLowerCase();

            // Filter table rows based on the search text
            $('table tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });


</script>


        


      <script>
    function clearShift() {
        // Send an AJAX request to the PHP script to clear records
        $.ajax({
            type: "POST",
            url: "clear_shift.php",
            success: function(response) {
                // Display the response message (e.g., success or error message) on the page
                alert(response);

                // Optionally, update the page content dynamically without reloading
                // For example, you can update a specific section of the page
                // Here, let's assume you have a div with id "shiftClearedMessage"
                $("#shiftClearedMessage").html("Shift cleared successfully!");

                // You can add more logic to update other parts of the page as needed

                // Alternatively, you can also call additional functions or perform other actions here
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                alert("Error clearing shift: " + xhr.responseText);
            }
        });
    }
</script>




        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="create.php">



                  
          
                <input type="text" class="form-control" id="crecorderField" name="crecorder" style="color:red" value="<?=$_SESSION['employeeName']?>" readonly hidden>
                



           


                    <input type="text" class="form-control" id="addCshiftcodeField" name="cshiftcode" value="<?php 
date_default_timezone_set("Asia/Kuala_Lumpur");
$hour = date('G'); 

if ($hour >= 23 && $hour < 7) {
    echo "3rd Shift";
} else if ($hour >= 7 && $hour < 15) {
    echo "1st Shift";
} else if ($hour >= 15 && $hour < 23) {
    echo "2nd Shift";
}
?>
&nbsp;

" readonly hidden>





  <input type="text" class="form-control" id="clock" name="clock" hidden>

<script>
    function updateTime() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();

        // Format the time with leading zeros
        hours = ("0" + hours).slice(-2);
        minutes = ("0" + minutes).slice(-2);
        seconds = ("0" + seconds).slice(-2);

        // Display the time
        var clockElement = document.getElementById("clock");
        clockElement.value = hours + ":" + minutes + ":" + seconds;
    }

    // Update the time immediately
    updateTime();

    // Update the time every second
    setInterval(updateTime, 1000);
</script>











                   <input type="number" class="form-control" id="addBionumField" name="bionum" placeholder="Biometric No" required><br>
                   <input type="text" class="form-control" id="addCnameField" name="cname" readonly placeholder="Coater"><br>
                   

                   

                 



    
                    

     
                 <select class="form-control" id="sizeSelector" name="sizeSelector">
    <option value="large">Large/Extra Large Sizes</option>
    <option value="regular">Regular Sizes</option>
    <option value="medium">Medium Sizes</option>
    <option value="small">Small Sizes</option>
    <option value="xmini">Mini/Extra Mini Sizes</option>
    <option value="uniques">Unique Sizes</option>
</select>
<span id="selectedValueSpan" hidden></span>

<div style="display: flex; align-items: center;">
    <select class="form-control" id="result" name="result" style="width: 800px; margin-right: 10px;">
        <option value="" selected>Result Value</option>
        <!-- Add other options here if needed -->
    </select>
     <img id="infoImage" src="images/info.png" alt="Info" style="width: 30px; height: 30px; margin-bottom: 10px;" onclick="showDialog()">
</div>
  <script>
       
          function showDialog() {
        // Get the value of "psize" from the "csizefield"
        var psizeValue = document.getElementById("addCsizeField").value;

        // AJAX request to fetch "pdesc" from the server
        $.ajax({
            url: 'your_server_endpoint.php', // Replace with your actual server-side endpoint
            method: 'GET',
            data: { psize: psizeValue },
            success: function(response) {
                // Display the value of "psize" and "pdesc" in the alert
                alert("Size/Shape Code: " + psizeValue + "\nDescription: " + response);
            },
            error: function() {
                alert("Error fetching data from the server");
            }
        });
    }
    </script>




 <input type="text" class="form-control" id="addCsizeField" name="csize" readonly hidden required>





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

    // Function to update the sizeSelector and the span element when text changes
    function updateSizeSelectorAndSpan(textValue) {
        var sizeSelector = document.getElementById("sizeSelector");
        var selectedValueSpan = document.getElementById("selectedValueSpan");

        // Find the value based on the text
        var selectedValue = Object.keys(valueMapping).find(function (key) {
            return valueMapping[key] == textValue;
        });

        if (selectedValue !== undefined) {
            sizeSelector.value = selectedValue;
            selectedValueSpan.textContent = textValue;

            // Update the result select based on the textValue using AJAX
            updateResultSelect(textValue);
        } else {
            sizeSelector.value = ""; // Clear the dropdown if the text value is not found
            selectedValueSpan.textContent = "";

            // Clear the result select
            clearResultSelect();
        }
    }

   // Function to update the result select based on the textValue using AJAX
function updateResultSelect(textValue) {
    var resultSelect = document.getElementById("result");
    resultSelect.innerHTML = '<option value="" selected>Loading...</option>';

    // Use AJAX to fetch options from the server based on the textValue
    // Replace 'ajax_url' with the actual URL of your server-side script
    var ajax_url = 'fetch_options.php';

    // Make an AJAX request to fetch the options
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ajax_url + '?textValue=' + textValue, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the response as JSON (assuming the response is JSON)
            var options = JSON.parse(xhr.responseText);

            // Update the result select with new options
            resultSelect.innerHTML = '<option value="" selected>Select item code</option>';
            for (var i = 0; i < options.length; i++) {
                var option = options[i];
                resultSelect.innerHTML += '<option value="' + option.pshape + '" data-prate="' + option.prate + '" data-pblispcs="' + option.pblispcs + '" data-cid="' + option.cid + '">' + option.psize + '</option>';
            }
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            // Handle the error here if necessary
            resultSelect.innerHTML = '<option value="" selected>Error Loading Options</option>';
        }
    };

    xhr.send();
}

    // Function to clear the result select
    function clearResultSelect() {
        var resultSelect = document.getElementById("result");
        resultSelect.innerHTML = '<option value="" selected>Select item code</option>';
    }

    // Add an event listener to the sizeSelector dropdown
    var sizeSelector = document.getElementById("sizeSelector");
    sizeSelector.addEventListener("change", function () {
        var selectedValue = sizeSelector.value;
        if (valueMapping[selectedValue] !== undefined) {
            updateSizeSelectorAndSpan(valueMapping[selectedValue]);
        }
    });

    // Initial update when the page loads
    updateSizeSelectorAndSpan(valueMapping[sizeSelector.value]);


 // Add an event listener to the result select
    var resultSelect = document.getElementById("result");
    resultSelect.addEventListener("change", function () {
        var selectedOption = resultSelect.options[resultSelect.selectedIndex];
        var selectedText = selectedOption.textContent; // Get the text of the selected option
        updateAddCsizeField(selectedText);
    });

    // Function to update the addCsizeField input
    function updateAddCsizeField(selectedText) {
        var addCsizeField = document.getElementById("addCsizeField");
        addCsizeField.value = selectedText;
    }

    // Add an event listener to the result select
var resultSelect = document.getElementById("result");
resultSelect.addEventListener("change", function () {
    var selectedOption = resultSelect.options[resultSelect.selectedIndex];
    var selectedText = selectedOption.textContent; // Get the text of the selected option
    var prate = selectedOption.getAttribute("data-prate");
    var pblispcs = selectedOption.getAttribute("data-pblispcs");
    var cid = selectedOption.getAttribute("data-cid");

    updateAddCsizeField(selectedText);
    updateAddPrateField(prate);
    updateAddPblispcsField(pblispcs);
    updateAddCidField(cid);
});

// Function to update the addPrateField input
function updateAddPrateField(prate) {
    var addPrateField = document.getElementById("addPrateField");
    addPrateField.value = prate;
}

// Function to update the addPblispcsField input
function updateAddPblispcsField(pblispcs) {
    var addPblispcsField = document.getElementById("addPblispcsField");
    addPblispcsField.value = pblispcs;
}

// Function to update the addPblispcsField input
function updateAddCidField(cid) {
    var addCidField = document.getElementById("addCidField");
    addCidField.value = cid;
}


  // Add event listeners to the sizeSelector dropdown and addCsizeField input
    var sizeSelector = document.getElementById("sizeSelector");
    sizeSelector.addEventListener("change", function () {
        var selectedValue = sizeSelector.value;
        if (valueMapping[selectedValue] !== undefined) {
            updateSizeSelectorAndSpan(valueMapping[selectedValue]);
            clearAdditionalFields();
        }
    });

    var result = document.getElementById("result");
    result.addEventListener("input", function () {
        clearAdditionalFields();
    });

 

    // Function to clear the additional fields
    function clearAdditionalFields() {
        var addCszrateField = document.getElementById("addCszrateField");
        var addTotalpblispcsField = document.getElementById("addTotalpblispcsField");
        var addCoutputField = document.getElementById("addCoutputField");

        addCszrateField.value = "";
        addTotalpblispcsField.value = "";
        addCoutputField.value = "";
    }


</script>


        
         <input type="text" class="form-control" id="addCidField" name="cid" readonly hidden>
        <input type="text" class="form-control" id="addPrateField" name="prate" readonly hidden required>
        <input type="text" class="form-control" id="addPblispcsField" name="pblispcs" readonly hidden required>



      
        
        
<input type="text" class="form-control" id="batchNoField" name="batchno"  placeholder="Batch No" hidden>

<script>
    // Function to update the addCsizeField input
    function updateAddCsizeField(value) {
        document.getElementById("addCsizeField").value = value;
        
        // Check if the value contains "cone" or "basket" and show the batchNumberField accordingly
        var batchNoField = document.getElementById("batchNoField");
        if (value.includes("cone") || value.includes("basket") || value.includes("Basket") || value.includes("Cone")) {
            batchNoField.removeAttribute("hidden");
        } else {
            batchNoField.setAttribute("hidden", "true");
        }
    }

    // Add an event listener to the csize input field
    var csizeField = document.getElementById("addCsizeField");
    csizeField.addEventListener("input", function() {
        updateAddCsizeField(csizeField.value);
    });
</script>
        
        <input type="number" class="form-control" id="addCoutputField" name="coutput" readonly placeholder="Blister output" required hidden>
        <input type="button" class='btnoutput' onclick="showme('1')" value="1" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('2')" value="2" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('3')" value="3" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('4')" value="4" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('5')" value="5" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('6')" value="6" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('7')" value="7" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('8')" value="8" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('9')" value="9" style="border-radius:4px; color: white; background-color:#85929E" />
        <input type="button" class='btnoutput' onclick="showme('10')" value="10" style="border-radius:4px; color: white; background-color:#85929E" /><br>


        <script type="text/javascript">
            function showme(count) {
                document.getElementById("addCoutputField").value = count;
                var buttons = document.getElementsByClassName("btnoutput");
                for (var j = 0; j < buttons.length; j++) {
                    buttons[j].style.backgroundColor = "#85929E";
                }
                event.currentTarget.style.backgroundColor = "gray";
            }
        </script><br>
<input type="text" class="form-control" id="addTotalpblispcsField" name="totalpblispcs" readonly placeholder="Total pcs per blister" required>
      



    
        <input type="text" class="form-control" id="addCszrateField" name="cszrate" readonly placeholder="Total Incentive rate" required>



        <button type="submit" style="background-color: #85929E;">Add Data</button>







        <script src="jquery-3.5.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.btnoutput').click(function () {
                    var x = Number($("#addPrateField").val());
                    var y = Number($("#addCoutputField").val());
                    var z = Number($("#addPblispcsField").val());
                    var totalz = z * y;
                    $('#addCszrateField').val('');
                    $('#addTotalpblispcsField').val(totalz);
                    $('#addCszrateField').val(totalz * x);
                });

          

               
                $('#addBionumField').keyup(function () {
                    var sid = $(this).val();
                    var data_String = 'sid=' + sid;
                     $.get('get_employee_data.php', data_String, function (result) {
                        $.each(result, function () {
                            $('#addBionumField').val(this.Bio);
                            $('#addCnameField').val(this.EmployeeName);
                        });
                    });
                });

                
     

                $('#addCsizeField').change(function () {
                    var coatid = $(this).val();
                    var data_String = 'coatid=' + coatid;
                    $.get('coatingshape.php', data_String, function (result) {
                        $.each(result, function () {
                            $('#addCsizeField').val(this.psize);
                            $('#addPrateField').val(this.prate);
                            $('#addPblispcsField').val(this.pblispcs);
                            $('#addTotalpblispcsField').val('');
                            $('#addCoutputField').val('');
                            $('#addCszrateField').val('');






                           
 function updateFieldsBasedOnCsize(selectedText) {
    var coatid = selectedText;
    var data_String = 'coatid=' + coatid;
    

    
    // You can modify the URL to match your server-side script
    $.get('coatingshape.php', data_String, function (result) {
      $.each(result, function () {
        $('#editCsizeField').val(this.psize);
        $('#addPrateField').val(this.prate);
        $('#addPblispcsField').val(this.pblispcs);
        $('#editTotalpblispcsField').val('');
        $('#editCoutputField').val('');
        $('#editCszrateField').val('');
         $('#editBatchNoField').val('');
      });
    });
  }

  // Add an event listener to #addCsizeField2 using jQuery
  $('#addCsizeField2').change(function () {
    var selectedText = $(this).val();
    updateFieldsBasedOnCsize(selectedText);
  });


                        });
                    });
                });
            });
        </script>
    </form>
    </div>
</div>





<script type="text/javascript">
    // Get the modal and button elements
    var modal = document.getElementById("myModal");
    var openBtn = document.getElementById("openAddModal");
    var closeBtn = document.getElementsByClassName("close")[0];

    // Open the modal when the "Add" button is clicked
    openBtn.onclick = function() {
        modal.style.display = "block";
    }

    // Close the modal when the close button is clicked
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>



 <table border="1">
    <tr>
        <th hidden>ID</th>
        <th hidden>Biometric No</th>
        <th>Coater</th>
        <th hidden>Size ID</th>
        <th>Size</th>
        <th hidden>Pcs/Rate</th>
        <th hidden>Pcs/Blister</th>
        <th>Total Pcs</th>
        <th>Blister Output</th>
        <th>Total Incentive</th>
        <th>Batch No</th>
        <th>Action</th>
    </tr>
<?php
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td hidden>" . $row['id'] . "</td>";
            echo "<td hidden>" . $row['bionum'] . "</td>";
            echo "<td>" . $row['cname'] . "</td>";
              echo "<td hidden>" . $row['cid'] . "</td>";
            echo "<td>" . $row['csize'] . "</td>";
            echo "<td hidden>" . $row['prate'] . "</td>";
            echo "<td hidden>" . $row['pblispcs'] . "</td>";
            echo "<td>" . $row['totalpblispcs'] . "</td>";
            echo "<td>" . $row['coutput'] . "</td>";
            echo "<td>" . $row['cszrate'] . "</td>";
            echo "<td>" . $row['batchno'] . "</td>";

            // Check user role and display "Correct" button accordingly
            if ($_SESSION['user_role'] == "Coating Supervisor") {
                echo "<td><button class='styled-button' id='openEditModal' onclick='openEditModal(\"" . $row['bionum'] . "\", \"" . $row['cname'] . "\", \"" . $row['cid'] . "\", \"" . $row['csize'] . "\", \"" . $row['prate'] . "\", \"" . $row['pblispcs'] . "\", \"" . $row[''] . "\", \"" . $row['coutput'] . "\", \"" . $row[''] . "\", \"" . $row['batchno'] . "\")'>Update</button>";
              echo "<button class='styled-button green-button' onclick='window.location.href=\"correctrecord.php?bionum=" . $row['bionum'] . "\"'>Correct</button> </td>";

            } else {
                echo "<td><button class='styled-button' id='openEditModal' onclick='openEditModal(\"" . $row['bionum'] . "\", \"" . $row['cname'] . "\", \"" . $row['cid'] . "\", \"" . $row['csize'] . "\", \"" . $row['prate'] . "\", \"" . $row['pblispcs'] . "\", \"" . $row[''] . "\", \"" . $row['coutput'] . "\", \"" . $row[''] . "\", \"" . $row['batchno'] . "\")'>Update</button>";
                 echo "<button class='styled-button green-button' onclick='window.location.href=\"viewrecord.php?bionum=" . $row['bionum'] . "\"'>View</button> </td>";
            }

            echo "</tr>";
        }
    } else {
        echo "No data available.";
    }
?>



</table>

<?php include 'update.php'; ?>

<script type="text/javascript">
   // Function to open the edit modal with data
function openEditModal(bionum, cname, cid, csize, prate, pblispcs, totalpblispcs, coutput, cszrate, batchno) {
    var editBionumField = document.getElementById("editBionumField");
    var editCidField = document.getElementById("editCidField");
    var editCsizeField = document.getElementById("editCsizeField");
    var sizeSelector = document.getElementById("sizeSelector");
    var displayPrate = document.getElementById("displayPrate")
    var displayPblispcs = document.getElementById("displayPblispcs")

    // Populate the edit modal with data from the selected row
    editBionumField.value = bionum;
    document.getElementById("editCnameField").value = cname;
     document.getElementById("editCidField").value = cid;
    editCsizeField.value = csize; // Set the hidden input for 'csize'
    document.getElementById("editTotalpblispcsField").value = totalpblispcs;
    document.getElementById("editCoutputField").value = '';
    document.getElementById("editCszrateField").value = cszrate;
    document.getElementById("editBatchNoField").value = batchno;
    document.getElementById("displayPrate").value = prate;
    document.getElementById("displayPblispcs").value = pblispcs;

    // Update the "Size" dropdown based on the 'csize' value
    sizeSelector.value = valueMapping[csize];

    // Update the "Result Value" dropdown based on the 'csize' value
    updateResultSelect(csize);

    // Show the edit modal
    editModal.style.display = "block";
}

</script>


</body>
</html>

