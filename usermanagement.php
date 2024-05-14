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
$sql = "SELECT u.`userid`, u.`username`, u.`password`, u.`biometricno`, u.`role`, u.`online_status`, u.`avatar_path`, e.`EmployeeName`
        FROM `sysusers` u
        LEFT JOIN `employeeinfo` e ON u.`biometricno` = e.`Bio`";

// Execute the query
$result = $conn->query($sql);

// Check if there are rows returned
// Check if there are rows returned
if ($result->num_rows > 0) {




     echo '<br><button class="add-account-button">Add Account</button>';
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
        echo '<td><button class="update-button" data-userid="' . $row["userid"] . '">Update</button>&nbsp;<button>Print</button></td>';
      
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <style>
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
            background-color: #f2f2f2;
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
            margin-top: 70px;
            margin-left: 300px;
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

    <script>
function updateStatus() {
    // Fetch the user status for all users from the server
    fetch('get-user-status.php')
        .then(response => response.json())
        .then(data => {
            const statusCells = document.querySelectorAll('.user-status');

            // Loop through the user rows and update the status cell
            statusCells.forEach((statusCell, index) => {
                const status = data[index].online_status;
                if (statusCell.textContent !== status) {
                    statusCell.textContent = status;
                    if (status === "Logged Out") {
                        statusCell.style.color = "red";
                    } else {
                        statusCell.style.color = "green";
                    }
                }
            });
        })
        .catch(error => {
            console.error(error);
        });
}

// Call the updateStatus function every 5 seconds (adjust the interval as needed)
setInterval(updateStatus, 1000);
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
               <!--  <input type="text" id="editRole" name="editRole"> -->



                   <select  id="editRole" name="editRole" required>
           
              <option value="User" selected>User</option>
              <option value="Admin">Administrator</option>
              <option value="Super Admin">Super Administrator</option>
              <option value="Coating Supervisor">Coating Supervisor</option>
              <option value="Coating Recorder">Coating Recorder</option>
              <option value="Sales Manager">Sales Manager</option>
              <option value="Sales Personnel">Sales Personnel</option>
              
            </select>

<br>




                <label for="editOnlineStatus" hidden>Online Status:</label>
                <input type="text" id="editOnlineStatus" name="editOnlineStatus" hidden>
                <label for="editAvatarPath" hidden>Avatar Path:</label>
                <input type="text" id="editAvatarPath" name="editAvatarPath" hidden>
                <button type="submit">Save changes</button>
            </form>
        </div>
    </div>
    


    <!-- Add Account Modal -->
<div id="addAccountModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddAccountModal()">&times;</span>
        <h2>Add New Account</h2>
        <form action="insert-script.php" method="post">
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
           
              <option value="User" selected>User</option>
              <option value="Admin">Administrator</option>
              <option value="Super Admin">Super Administrator</option>
               <option value="Coating Supervisor">Coating Supervisor</option>
               <option value="Coating Recorder">Coating Recorder</option>
               <option value="Sales Manger">Sales Manager</option>
              <option value="Sales Personnel">Sales Personnel</option>
            </select>
          </div>

    <button type="submit">Create Account</button>
</form>

    </div>
</div>

</body>
</html>
