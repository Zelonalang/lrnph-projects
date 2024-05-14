




    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <form method="POST" action="edit.php">
                <input type="hidden" id="editRecordID" name="editRecordID">







 <input type="text" class="form-control" id="ecrecorderField" name="ecrecorderField" style="color:red" value="<?=$_SESSION['employeeName']?>" readonly hidden>
           
 

                    <input type="text" class="form-control" id="addCshiftcodeField" name="cshiftcode" value=" <?php 
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


<input type="text" class="form-control" id="eclock" name="eclock" hidden>

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
        var clockElement = document.getElementById("eclock");
        clockElement.value = hours + ":" + minutes + ":" + seconds;
    }

    // Update the time immediately
    updateTime();

    // Update the time every second
    setInterval(updateTime, 1000);
</script>



              <!-- Input field for editing 'bionum' -->
    <label for="editBionumField" hidden>Biometric No:</label>
    <input type="number" class="form-control" id="editBionumField" name="editBionumField" placeholder="Biometric No" required hidden><br>

    <!-- Input field for editing 'cname' -->
    <label for="editCnameField" hidden>Coater:</label>
    <input type="text" class="form-control" id="editCnameField" name="editCnameField" placeholder="Coater" required readonly><br>

     <input type="text" class="form-control" id="editCidField" name="editCidField" placeholder="Size ID" required readonly hidden>



    <select class="form-control" id="sizeSelector2" name="sizeSelector2" onchange="toggleFields()">
        <option value="" selected>Select other sizes</option>
        <option value="large">Large/Extra Large Sizes</option>
        <option value="regular">Regular Sizes</option>
        <option value="medium">Medium Sizes</option>
        <option value="small">Small Sizes</option>
        <option value="xmini">Mini/Extra Mini Sizes</option>
        <option value="uniques">Unique Sizes</option>
    </select>
    <span id="selectedValueSpan2" hidden></span>
<div style="display: flex; align-items: center;">
    <select class="form-control" id="result2" name="result2" style="display: none; width: 800px; margin-right: 10px;">
        <option value="" selected>Result Value</option>
    </select>
   


 <script>
       
          function showDialog2() {
        // Get the value of "psize" from the "csizefield"
        var psizeValue = document.getElementById("editCsizeField").value;

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



    <label for="editCsizeField" hidden>Size:</label>
    <input type="text" class="form-control" id="editCsizeField" name="editCsizeField" placeholder="Size" readonly required onchange="clearOtherFields()" style=" width: 800px; margin-right: 10px;">
     <img id="infoImage2" src="images/info.png" alt="Info2" style="width: 30px; height: 30px; margin-bottom: 10px;" onclick="showDialog2()">
</div>
    <script type="text/javascript">
        function toggleFields() {
            var sizeSelector = document.getElementById("sizeSelector2");
            var resultSelect = document.getElementById("result2");
            var editCsizeField = document.getElementById("editCsizeField");
            

             editTotalpblispcsField.value = "";
            editCoutputField.value = "";
            editCszrateField.value = "";
            editCsizeField.value = "";
              /*editCsizeField.value = "";*/
            

            if (sizeSelector.value !== "sizes") { // Adjust the condition as needed
                resultSelect.style.display = "block";
                editCsizeField.style.display = "none";
               
            } else {
                resultSelect.style.display = "none";
                editCsizeField.style.display = "block";
               

            }
        }



    </script>
    <label for="displayPrate" hidden>Prate:</label>
    <input type="text" class="form-control" id="displayPrate" name="displayPrate" readonly hidden>
    <label for="displayPblispcs" hidden>Pblispcs:</label>
    <input type="text" class="form-control" id="displayPblispcs" name="displayPblispcs" readonly hidden>
<script>
    function clearOtherFields() {
        var editCsizeField = document.getElementById("editCsizeField");
        var displayPrate = document.getElementById("displayPrate");
        var displayPblispcs = document.getElementById("displayPblispcs");
        var editCoutputField = document.getElementById("editCoutputField");
        var editCszrateField = document.getElementById("editCszrateField");
        var editCidField = document.getElementById("editCidField");

        // Call the fetchPrateAndPblispcs function to get prate and pblispcs based on csize
        var csizeValue = editCsizeField.value;
        fetchPrateAndPblispcs(csizeValue, function(response) {
            // Update displayPrate and displayPblispcs based on the response
            if (response) {
                displayPrate.value = response.prate;
                displayPblispcs.value = response.pblispcs;
                editCidField.value = response.cid;

            
            } else {
                // Handle the case where the fetch fails
                displayPrate.value = '';
                displayPblispcs.value = '';
                editCidField.value = '';

     
            }
        });
    }


</script>


<input type="text" class="form-control" id="editBatchNoField" name="editBatchNoField" placeholder="Batch No">

<script>
    // Function to update the addCsizeField input
    function updateEditCsizeField(value) {
        document.getElementById("editCsizeField").value = value;
        
        // Check if the value contains "cone" or "basket" and show the batchNumberField accordingly
        var editBatchNoField = document.getElementById("editBatchNoField");
        if (value.includes("cone") || value.includes("basket") || value.includes("Basket") || value.includes("Cone")) {
            editBatchNoField.removeAttribute("hidden");
        } else {
            editBatchNoField.setAttribute("hidden", "true");
        }
    }

    // Add an event listener to the csize input field
    var csizeField = document.getElementById("editCsizeField");
    csizeField.addEventListener("input", function() {
        updateEditCsizeField(csizeField.value);
    });
</script>



    <label for="editCoutputField" hidden>Blister Output:</label>
    <input type="number" class="form-control" id="editCoutputField" name="editCoutputField" placeholder="Blister Output" required readonly hidden> 

            <input type="button" class='btnoutput' onclick="editshowme('1')" value="1" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('2')" value="2" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('3')" value="3" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('4')" value="4" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('5')" value="5" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('6')" value="6" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('7')" value="7" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('8')" value="8" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('9')" value="9" style="border-radius:4px; color: white; background-color:#85929E" />
            <input type="button" class='btnoutput' onclick="editshowme('10')" value="10" style="border-radius:4px; color: white; background-color:#85929E" /><br> <script type="text/javascript">
                function editshowme(count) {
                    document.getElementById("editCoutputField").value = count;
                    var buttons = document.getElementsByClassName("btnoutput");
                    for (var j = 0; j < buttons.length; j++) {
                        buttons[j].style.backgroundColor = "#85929E";
                    }
                    event.currentTarget.style.backgroundColor = "gray";
                }
            </script>
                    <script src="jquery-3.5.0.min.js"></script>
                     <script type="text/javascript">
                 $(document).ready(function () {
                    $('.btnoutput').click(function () {
                        var x = Number($("#displayPrate").val());
                        var y = Number($("#editCoutputField").val());
                        var z = Number($("#displayPblispcs").val());
                        var totalz = z * y;
                        $('#editCszrateField').val('');
                        $('#editTotalpblispcsField').val(totalz);
                        $('#editCszrateField').val(totalz * x);
                    });
                      });
                </script>
           
            <br>
    <!-- Input field for editing 'totalpblispcs' -->
    <label for="editTotalpblispcsField" hidden>Total pcs per blister:</label>
    <input type="number" class="form-control" id="editTotalpblispcsField" name="editTotalpblispcsField" placeholder="Total pcs per blister" required readonly ><br> <label for="editCszrateField" hidden>Total Incentive rate:</label>
    <input type="text" class="form-control" id="editCszrateField" name="editCszrateField" placeholder="Total Incentive rate" required readonly ><br>




  



    <br>
<script type="text/javascript">
        // Define a mapping of values for the options in Modal 2
        var valueMapping2 = {
            "large": "large",
            "regular": "regular",
            "small": "small",
            "xmini": "mini",
            "uniques": "unique",
            "medium": "medium"
        };

        function updateSizeSelectorAndSpan2(textValue) {
            var sizeSelector = document.getElementById("sizeSelector2");
            var selectedValueSpan = document.getElementById("selectedValueSpan2");

            // Find the value based on the text in Modal 2
            var selectedValue = Object.keys(valueMapping2).find(function (key) {
                return valueMapping2[key] == textValue;
            });

            if (selectedValue !== undefined) {
                sizeSelector.value = selectedValue;
                selectedValueSpan.textContent = textValue;

                // Update the result select in Modal 2 based on the textValue using AJAX
                updateResultSelect2(textValue);
            } else {
                sizeSelector.value = ""; // Clear the dropdown if the text value is not found
                selectedValueSpan.textContent = "";

                // Clear the result select in Modal 2
                clearResultSelect2();
            }
        }

        // Function to update the result select in Modal 2 based on the textValue using AJAX
        function updateResultSelect2(textValue) {
            var resultSelect = document.getElementById("result2");
            resultSelect.innerHTML = '<option value="" selected>Loading...</option>';

            // Use AJAX to fetch options from the server based on the textValue in Modal 2
            // Replace 'ajax_url' with the actual URL of your server-side script
            var ajax_url = 'fetch_options.php';

            // Make an AJAX request to fetch the options in Modal 2
            var xhr = new XMLHttpRequest();
            xhr.open('GET', ajax_url + '?textValue=' + textValue, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the response as JSON (assuming the response is JSON)
                    var options = JSON.parse(xhr.responseText);

                    // Update the result select in Modal 2 with new options
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

        // Function to clear the result select in Modal 2
        function clearResultSelect2() {
            var resultSelect = document.getElementById("result2");
            resultSelect.innerHTML = '<option value="" selected>Select item code</option>';
        }

        // Add an event listener to the sizeSelector dropdown in Modal 2
        var sizeSelector2 = document.getElementById("sizeSelector2");
        sizeSelector2.addEventListener("change", function () {
            var selectedValue = sizeSelector2.value;
            if (valueMapping2[selectedValue] !== undefined) {
                updateSizeSelectorAndSpan2(valueMapping2[selectedValue]);
            }
        });

        // Initial update when Modal 2 loads
        updateSizeSelectorAndSpan2(valueMapping2[sizeSelector2.value]);

        // Add an event listener to the result select in Modal 2
        var resultSelect2 = document.getElementById("result2");
        resultSelect2.addEventListener("change", function () {
            var selectedOption = resultSelect2.options[resultSelect2.selectedIndex];
            var selectedText = selectedOption.textContent; // Get the text of the selected option
            updateAddCsizeField2(selectedText); 
            updateDisplayPrateField(selectedOption.getAttribute("data-prate")); // Update 'displayPrate'
            updateDisplayPblispcsField(selectedOption.getAttribute("data-pblispcs")); 
            updateEditCidField(selectedOption.getAttribute("data-cid"));// Update 'displayPblispcs'
    });
        // Function to update the addCsizeField input in Modal 2
        function updateAddCsizeField2(selectedText) {
            var addCsizeField2 = document.getElementById("editCsizeField");
            editCsizeField.value = selectedText;
        }

    function updateDisplayPrateField(prate) {
        var displayPrate = document.getElementById("displayPrate");
        displayPrate.value = prate;
    }

    function updateDisplayPblispcsField(pblispcs) {
        var displayPblispcs = document.getElementById("displayPblispcs");
        displayPblispcs.value = pblispcs;
    }

      function updateEditCidField(cid) {
        var editCidField = document.getElementById("editCidField");
        editCidField.value = cid;
    }
  </script>
 <script>
      // Get references to the input fields
      const addCsizeField2 = document.getElementById('addCsizeField2');
      const editCsizeField = document.getElementById('editCsizeField');

      // Add an onchange event handler to csize2 input field
      addCsizeField2.onchange = function () {
        // Update the value of editCsizeField when csize2 changes
        editCsizeField.value = addCsizeField2.value;
      };


     

    </script>

                <button type="submit" style="background-color: #85929E;">Save Changes</button>
            </form>
        </div>
    </div>
<script>
    // Get a reference to the close button
    var closeEditModalButton = document.getElementById("closeEditModal");

    // Add a click event listener to close the modal
    closeEditModalButton.addEventListener("click", function() {
        // Get a reference to the editModal
        var editModal = document.getElementById("editModal");

        // Hide the modal by changing its style
        editModal.style.display = "none";
    });
</script>

