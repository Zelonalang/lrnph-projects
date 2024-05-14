<?php include 'header.php'; ?>



<?php
// Replace these with your database connection details
$servername = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT `userid`, `username`, `password`, `biometricno`, `role`, `online_status`, `avatar_path`, `EmployeeName`
FROM `sysusers`
LEFT JOIN `employeeinfo` ON `biometricno` = `Bio`
WHERE `role` = 'Coating Recorder' OR `role` = 'Coating Supervisor'
LIMIT 0, 25";

// Execute the query
$result = $conn->query($sql);

// Check if there are rows returned
// Check if there are rows returned
if ($result->num_rows > 0) {


    echo   "<div class='content-container'>";
    echo "<h2>Production Coating Accounts</h2><br>";
    echo '&nbsp;<button class="add-account-button" style="background-color: #85929E;">Add Account</button>';
    echo "<table>";
    echo "<tr>";
    echo "<th hidden>User ID</th>";
    echo "<th>Status</th>"; // Changed the column header
    echo "<th>Employee Name</th>";
    echo "<th>Username</th>";
    echo "<th hidden>Password</th>";
    echo "<th>Biometric Number</th>";
    echo "<th>Role</th>";
    echo "<th hidden>Avatar Path</th>";
    echo "<th></th>"; // New column for the modal
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td hidden>" . $row["userid"] . "</td>";
        echo "<td>"; // Start of the Status cell
        // Check if the status is "Logged Out" and display a red dot, otherwise, display a green dot
        if ($row["online_status"] === "Logged Out") {
            echo '<span style="color: red; font-size:35px;">&#x25CF;</span>';
        } else {
            echo '<span style="color: green; font-size:35px;">&#x25CF;</span>';
        }
        echo "</td>"; // End of the Status cell
        echo "<td>" . $row["EmployeeName"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td hidden>" . $row["password"] . "</td>";
        echo "<td>" . $row["biometricno"] . "</td>";
        echo "<td>" . $row["role"] . "</td>";
        echo "<td hidden>" . $row["avatar_path"] . "</td>";
        // Add a button or link to open the modal
        echo '<td><button class="update-button" data-userid="' . $row["userid"] . '" style="background-color: #85929E;">Update</button>&nbsp;<button style="background-color: #85929E;">Print</button></td>';
      
        echo "</tr>";
    }

    echo "</table>";
      echo "</div>";
} else {
    echo "No records found.";
}








// SQL query for the second data table
$sql2 = "SELECT `cid`, `psize`, `pdesc`, `prate`, `pblister`, `pblispcs`, `sunq`, `pshape`, `actionby`, `actionstatus`
FROM `pentbl_coating`
WHERE actionstatus = 'for approval'";

// Execute the second query
$result2 = $conn->query($sql2);

// Check if there are rows returned for the second query
if ($result2->num_rows > 0) {
    echo "<br><br><br><br>";
    echo   "<div class='content-container2'>
     <h2>Coating Shape/Sizes Request</h2>";
     echo '&nbsp;<br><button id="NewSize" class="styled-button" onclick="redirectTonewsize()" style="background-color: #85929E;">New Size</button><br>';
    echo "<table>";
    echo "<tr>";
    echo "<th hidden>CID</th>";
    echo "<th>Size/Shape</th>";
    echo "<th>Description</th>";
    echo "<th>Rate/Pcs</th>";
    echo "<th hidden>Product Blister</th>";
    echo "<th>Pcs/Blister</th>";
    echo "<th hidden>SUNQ</th>";
    echo "<th>Shape classification</th>";
    echo "<th>Requester</th>";
    echo "<th></th>";
    echo "</tr>";

    while ($row2 = $result2->fetch_assoc()) {
    echo "<tr>";
    echo "<td hidden>" . $row2["cid"] . "</td>";
    echo "<td>" . $row2["psize"] . "</td>";
    echo "<td>" . $row2["pdesc"] . "</td>";
    echo "<td>" . $row2["prate"] . "</td>";
    echo "<td hidden>" . $row2["pblister"] . "</td>";
    echo "<td>" . $row2["pblispcs"] . "</td>";
    echo "<td hidden>" . $row2["sunq"] . "</td>";
    echo "<td>" . $row2["pshape"] . "</td>";
    echo "<td>" . $row2["actionby"] . "</td>";
    echo '<td><button class="approve-button" data-cid="' . $row2["cid"] . '" style="background-color: #85929E;">Approve</button></td>';
    echo "</tr>";
}


    echo "</table><br>";
    echo "</div>";
} else {
    echo "<br>&nbsp;&nbsp;   <button id='NewSize' class='styled-button' onclick='redirectTonewsize()' style='background-color: #85929E;'>New Size</button> &nbsp;No new size/shape request to approve. <br>";
   
}

// Close the database connection
$conn->close();
?>
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
                window.location.href = "coatermngmnt.php";
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


<script>


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


</script>

<!DOCTYPE html>
<html>
<head>
    <style>




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
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 14px;
}



     table {

            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
 
        }

        table th, table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        table th {
            background-color: #85929E;
            font-family: Arial, sans-serif;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

         .modal {
             font-family: Arial, sans-serif;
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
            overflow: auto;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease-in-out; /* Add transition for fade effect */
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            max-width: 400px;
            margin-top: 65px;
            margin-left: 350px;
            width: 80%;
            transition: transform 0.3s ease-in-out; /* Add transition for pop-up effect */
        }

        /* Add transition for close button */
        .close {
            color: #000;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        .close:hover {
            color: #f00;
        }

        /* Show the modal with animation */
        .modal.active {
            display: flex;
            opacity: 1;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

         form {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label {
        width: 100%;
        text-align: left;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
    }


    /* CSS for Create Account Modal */
.form-group {
    margin-bottom: 10px;
}

.form-group input,
.form-group select {
    width: 210%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Center the button */
.form-group button {
    display: block;
    margin: 0 auto;
}


  /* CSS for the div */
        .content-container {
            margin-top: 68px;
            margin-left: 5px;
            margin-right: 5px;
            padding: 20px; /* Add your desired padding */
            background-color: #f5f5f5; /* Add your desired background color */
            border: 10px solid #ccc; /* Add your desired border style */
            border-radius: 5px; /* Add border radius if needed */
        }

/* CSS for the div */
        .content-container2 {
            margin-top: -60px;
            margin-left: 5px;
            margin-right: 5px;
            padding: 20px; /* Add your desired padding */
            background-color: #f5f5f5; /* Add your desired background color */
            border: 10px solid #ccc; /* Add your desired border style */
            border-radius: 5px; /* Add border radius if needed */
        }


.content-container3 {
            margin-top: -5px;
            margin-left: 5px;
            margin-right: 5px;
            padding: 20px; /* Add your desired padding */
            background-color: #f5f5f5; /* Add your desired background color */
            border: 10px solid #ccc; /* Add your desired border style */
            border-radius: 5px; /* Add border radius if needed */
        }
    </style>

    <script>


         function openAddAccountModal() {
        const addAccountModal = document.getElementById("addAccountModal");
        addAccountModal.style.display = "block";
    }

    function closeAddAccountModal() {
        const addAccountModal = document.getElementById("addAccountModal");
        addAccountModal.style.display = "none";
    }





 // Event listener for the "Add Account" button
    const addAccountButton = document.getElementsByClassName("add-account-button")[0];
    addAccountButton.addEventListener("click", openAddAccountModal);





        function closeModal() {
            document.getElementById("updateModal").style.display = "none";
        }

        document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("updateModal");
    const updateButton = document.getElementsByClassName("update-button");

    for (let i = 0; i < updateButton.length; i++) {
        updateButton[i].addEventListener("click", function () {
            const userId = this.getAttribute("data-userid");
            // Use AJAX to fetch user data for the selected row
            // Modify the URL to your data retrieval script
            fetch('get-user-data.php?userId=' + userId)
                .then(response => response.json())
                .then(data => {
                    // Populate the modal form fields with the retrieved data
                    document.getElementById("editUserId").value = data.userid;
                    document.getElementById("editUsername").value = data.username;
                    document.getElementById("editPassword").value = data.password;
                    document.getElementById("editBiometricNo").value = data.biometricno;
                    document.getElementById("editRole").value = data.role;
                    document.getElementById("editOnlineStatus").value = data.online_status;
                    document.getElementById("editAvatarPath").value = data.avatar_path;

                    // Show the modal
                    modal.style.display = "block";

                    // Add an event listener to the "Edit Password" field
const editPasswordField = document.getElementById("editPassword");
editPasswordField.style.color = "white"; // Set the initial text color to white

editPasswordField.addEventListener("click", function () {
    // Check if the text color is white
    if (editPasswordField.style.color === "white") {
        editPasswordField.style.color = "black"; // Set text color to black when clicked
    }
    // Clear the value when the field is clicked
    editPasswordField.value = '';
                    });
                });
        });
    }
});


        function submitForm(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById("updateForm"));

            // Send the form data to a PHP script that handles the update (AJAX request)
            // Replace 'update-script.php' with the actual script that processes the update.
            fetch('update-script.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                // Handle the response from the server (e.g., show success message)
                alert(data);
                closeModal();
            })
            .catch(error => {
                console.error(error);
            });
        }




   


    </script>
</head>
<body>
    <!-- The modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit User Details</h2>
            <form id="updateForm" onsubmit="submitForm(event)">
                <input type="hidden" id="editUserId" name="editUserId">
                <label for="editUsername">Username:</label>
                <input type="text" id="editUsername" name="editUsername">
                <label for="editPassword">Password:</label>
                <input type="text" id="editPassword" name="editPassword">
                <label for="editBiometricNo" hidden>Biometric Number:</label>
                <input type="text" id="editBiometricNo" name="editBiometricNo" hidden>
                <label for="editRole">Role:</label>
                <input type="text" id="editRole" name="editRole">
                <label for="editOnlineStatus" hidden>Online Status:</label>
                <input type="text" id="editOnlineStatus" name="editOnlineStatus" hidden>
                <label for="editAvatarPath" hidden>Avatar Path:</label>
                <input type="text" id="editAvatarPath" name="editAvatarPath" hidden>
                <button type="submit" style="background-color:#85929E;">Save changes</button>
            </form>
        </div>
    </div>
    


    <!-- Add Account Modal -->
<div id="addAccountModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddAccountModal()">&times;</span>
        <h2>Add New Account</h2>
        <form action="insert-script2.php" method="post">
    <!-- Fields for new account information -->
            <div class="form-group">
            <input type="text"  id="reg-username" name="reg-username" placeholder="Username" required>
          </div>
          <div class="form-group">
          <input type="password"  id="reg-password" name="reg-password" placeholder="Password" required>
          </div>
           <div class="form-group">
           <input type="text"  id="reg-biometricno" name="reg-biometricno" placeholder="Biometric No" required>
          </div>
             <div class="form-group">
     
            <select  id="reg-role" name="reg-role" required>
           
              <!-- <option value="User" selected>User</option>
              <option value="Admin">Administrator</option>
              <option value="Super Admin" >Super Administrator</option> -->
               <option value="Coating Supervisor" >Coating Supervisor</option>
               <option value="Coating Recorder" >Coating Recorder</option>
            </select>
          </div>

    <button type="submit" style="background-color: #85929E;">Create Account</button>
</form>

    </div>
</div>





<br>

<div class="content-container3">
     <h2>Coating Shape/Sizes</h2>
<?php include 'shapelist.php'; ?>
</div>
<br><br><br>

</body>
</html>
