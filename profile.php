   <?php include 'header.php'; ?>

   <?php
   // Your session variables
   $username = $_SESSION['username'];
   $user_role = $_SESSION['user_role'];
   $employeeName = $_SESSION['employeeName'];

   // Connect to your database (replace these values with your actual database credentials)
   $servername = "localhost";
   $username_db = "itadmin";
   $password_db = "La.rose1@)@!";
   $database = "lrnphdev";

   $conn = new mysqli($servername, $username_db, $password_db, $database);

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Fetch data from the database based on the session's user
   $query = "SELECT `userid`, `username`, `password`, `biometricno`, `role`, `online_status`, `avatar_path` 
             FROM `sysusers` 
             WHERE `username` = '$username'";

   $result = $conn->query($query);

   if ($result->num_rows > 0) {
       // Output data of each row
       while ($row = $result->fetch_assoc()) {
           // Create HTML input fields and populate them with the fetched data
           $userid = $row['userid'];
           $username = $row['username'];
           $password = $row['password'];
           $biometricno = $row['biometricno'];
           $role = $row['role'];
           $online_status = $row['online_status'];
           $avatar_path = $row['avatar_path'];

           // Verify the hashed password using password_hash
           $isPasswordVerified = password_verify($password, $password);

           // Now you can use these variables to populate your input fields
           ?>
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

               .useravatar {
                   width: 100px; /* Set the desired width */
                   height: 100px; /* Set the desired height */
                   border-radius: 50%; /* Create a circular shape */
                   overflow: hidden; /* Hide overflow content outside the border */
                   margin-bottom: 20px; /* Adjust the margin as needed */
               }

               .useravatar img {
                   width: 100%; /* Make the image fill the container */
                   height: 100%; /* Make the image fill the container */
                   object-fit: cover; /* Maintain aspect ratio and cover the container */
               }

               label {
                   margin-bottom: 1px;
               }

               span {
                   font-weight: bold;
                   margin-bottom: 5px;
               }

              
               .password-toggle {
                   cursor: pointer;
                   color: blue;
                   text-decoration: underline;
                   margin-top: 10px;
               }

                  #newPasswordField {
           padding: 5px;
           margin-bottom: 5px;
           width: 85%;
           box-sizing: border-box;
           font-size: 20px;
       }

       #changePasswordButton,
       #cancelChangePasswordButton,
       #savePasswordButton {
           padding: 10px;
           margin-top: 10px;
           cursor: pointer;
           border: none;
           color: #fff;
           border-radius: 5px;
           font-size: 14px;
           text-align: center;
       }


       

       #changePasswordButton {
           background-color: #007bff; /* Blue color for "Change Password" button */
       }

       #cancelChangePasswordButton {
           background-color: #dc3545; /* Red color for "Cancel" button */

       }

       #savePasswordButton {
           background-color: #28a745; /* Green color for "Save Password" button */
       }

       /* Add a check icon for the "Save Password" button */
       #savePasswordButton::before {
           content: '\2713'; /* Unicode checkmark character */
           margin-right: 5px;
       }

       /* Add an x icon for the "Cancel" button */
       #cancelChangePasswordButton::before {
          /* content: '\2716';  Unicode multiplication sign (x) character */
           margin-right: 5px;

       }

               #recentActivity {
                 width: 65%;
                   position: absolute;
                   top: 10px;
                   right: 10px;
                   left: 320px;
                   padding: 10px;
                   background-color: #eee;
                   border-radius: 5px;
                   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
               }
           </style>

           <div class="userdiv">
               <!-- Recent Activity Section -->



             <?php
$user_role = $_SESSION['user_role'];

// Check if the user role is "Super Administrator" or "Coating Supervisor"
if ($user_role == "Super Admin" || $user_role == "Coating Supervisor") {
    echo '<div id="recentActivity">';
    echo '<h3>Recent Activity</h3><br>';

    // Fetch recent activities from the "audit_trail" table
    $auditTrailQuery = "SELECT * FROM `audit_trail` ORDER BY `login_time` DESC LIMIT 3";
    $auditTrailResult = $conn->query($auditTrailQuery);
    if ($auditTrailResult->num_rows > 0) {
        echo "<p hidden><h4 hidden>Logins</h2></p>";
        echo "<ul hidden>";
        while ($auditTrailRow = $auditTrailResult->fetch_assoc()) {
            echo "<li>Logged In: {$auditTrailRow['username']} at {$auditTrailRow['login_time']}</li>";
        }
        echo "</ul>";
    }

    // Fetch recent activities from the "pentbl_coating" table
    $pentblCoatingQuery = "SELECT * FROM `pentbl_coating` ORDER BY `acdate` DESC LIMIT 3";
    $pentblCoatingResult = $conn->query($pentblCoatingQuery);
    if ($pentblCoatingResult->num_rows > 0) {
        echo "<p><h4>Coating Requests/Approvals</h2></p>";
        echo "<ul>";
        while ($pentblCoatingRow = $pentblCoatingResult->fetch_assoc()) {
            echo "<li>{$pentblCoatingRow['psize']} - {$pentblCoatingRow['pdesc']} <b>|</b> Requestor: {$pentblCoatingRow['actionby']} - {$pentblCoatingRow['actionstatus']}</li>";
        }
        echo "</ul><br>";
    }

    // Fetch recent activities from the "coatingprod" table
    $coatingprodQuery = "SELECT * FROM `coatingprod` ORDER BY `rmdate` DESC LIMIT 3";
    $coatingprodResult = $conn->query($coatingprodQuery);
    if ($coatingprodResult->num_rows > 0) {
        echo "<p><h4>Recordings of Production Coating <a href='coatinglogs.php'><img id='infoImage' src='images/redirect.png' alt='Info' style='width: 15px; height: 15px; margin-top: 10px;' ></a></h2></p>";
        echo "<ul>";
        while ($coatingprodRow = $coatingprodResult->fetch_assoc()) {
            echo "<li>Recorder: {$coatingprodRow['crecorder']} <b>|</b> Coater: {$coatingprodRow['cname']} - {$coatingprodRow['csize']}</li>";
        }
        echo "</ul><br>";
    }

    echo '</div>'; // Close the div
}
?>




            
   


               <!-- Your HTML input fields go here -->
               <div class="useravatar">
                   <?php
                   if (!empty($biometricno)) {
                       echo '<img src="images/emp/' . $biometricno . '.JPG" alt="User Avatar">';
                   } else {
                       echo '<img src="avatar.JPG" alt="Placeholder">';
                   }
                   ?>





                 <script type="text/javascript">
                 function displayUserAvatar($username) {
    $avatarPath = "/images/emp/{$biometricno}.jpg";
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $avatarPath)) {
        echo "<img src='{$avatarPath}' alt='User Avatar'>";
    } else {
        echo "<img src='/images/avatar.jpg' alt='Placeholder'>";
    }
}

// Usage example
if (!empty($username)) {
    displayUserAvatar($username);
}



</script>



               </div>

               <label>Biometric No:</label><span> <?php echo $biometricno; ?></span>
               <label>Name:</label><span><?= $_SESSION['employeeName'] ?></span>
               <label hidden>Username:</label><span hidden><?php echo $username; ?></span>

               <!-- Displaying the decrypted (plaintext) password only if verification is successful -->
               <?php if ($isPasswordVerified): ?>
                   <label>Password:</label>
                   <input type="text" name="password" id="passwordField" value="<?php echo $password; ?>" disabled/>
                   <span class="password-toggle" onclick="togglePassword()">Show/Hide</span>
               <?php endif; ?>

               <label>System Role:</label><span><?php echo $role; ?></span>

               <!-- "Change Password" button and input field for the new password -->
               <button id="changePasswordButton" onclick="showChangePassword()">Change Password</button>
               <div id="changePasswordSection" style="display: none;">
                   <label>New Password:</label><br>
                   <input type="password" name="newPassword" id="newPasswordField"/><br>
                   <button id="savePasswordButton" onclick="changePassword()">Save Password</button>
                   <button id="cancelChangePasswordButton" onclick="cancelChangePassword()">Cancel</button>
               </div>

               <input type="text" name="online_status" value="<?php echo $online_status; ?>" hidden/>
               <input type="text" name="avatar_path" value="<?php echo $avatar_path; ?>" hidden/>
               <!-- Add more input fields as needed -->
           </div>

           <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
           <script type="text/javascript">
               function togglePassword() {
                   var passwordField = document.getElementById('passwordField');
                   if (passwordField.type === 'password') {
                       passwordField.type = 'text';
                   } else {
                       passwordField.type = 'password';
                   }
               }

               function showChangePassword() {
                   var changePasswordSection = document.getElementById('changePasswordSection');
                   changePasswordSection.style.display = 'block';

                   // Hide the "Change Password" button
                   var changePasswordButton = document.getElementById('changePasswordButton');
                   changePasswordButton.style.display = 'none';
               }

               function changePassword() {
                   var newPassword = $('#newPasswordField').val();

                   // Perform an AJAX request to update the password
                   $.ajax({
                       type: 'POST',
                       url: 'change_password.php', // Replace with the actual PHP file handling the password change
                       data: {newPassword: newPassword},
                       success: function(response) {
                           if (response === 'success') {
                               alert('Password changed successfully');
                               hideChangePasswordSection(); // Hide the change password section
                           } else {
                               alert('Failed to change password');
                           }
                       }
                   });
               }

               function cancelChangePassword() {
                   hideChangePasswordSection();
               }

               function hideChangePasswordSection() {
                   var changePasswordSection = document.getElementById('changePasswordSection');
                   changePasswordSection.style.display = 'none';

                   // Show the "Change Password" button
                   var changePasswordButton = document.getElementById('changePasswordButton');
                   changePasswordButton.style.display = 'block';
               }
           </script>
           <?php
       }
   } else {
       echo "No records found";
   }

   // Close the database connection
   $conn->close();
   ?>
