
<?php include 'header.php'; ?>

<?php
// You can access user information like username from the session as needed
$username = $_SESSION['username'];

// Database connection information
$servername = "localhost";
$db_username = "itadmin";
$db_password = "La.rose1@)@!";
$dbname = "lrnphdev";

// Create a database connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
?>

<?php
// Assuming you have a valid database connection

// Define the username you want to search for
$usernameToSearch = $username; // Use the username from the session

// SQL query to retrieve the EmployeeName and Dept where Bio is equal to the username
$sql = "SELECT EmployeeName, Dept FROM employeeinfo WHERE Bio = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Handle the error if the prepare statement fails
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("s", $usernameToSearch);

// Execute the query
if ($stmt->execute()) {
    // Bind the results to variables
    $stmt->bind_result($employeeName, $Dept);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();
} else {
    // Handle the error if the execute statement fails
    die("Execute failed: " . $stmt->error);
}

// $employeeName and $Dept now contain the EmployeeName and Dept associated with the username


// Assuming you have successfully authenticated the user
// Insert a record into the audit trail table
$username = $_SESSION['username']; // Get the username from the session

$insert_sql = "INSERT INTO audit_trail (username) VALUES (?)";
$stmt = $conn->prepare($insert_sql);

if ($stmt) {
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        // Log record successfully inserted
    } else {
        // Handle the insert error
        echo "Error inserting record: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Handle the prepare statement error
    echo "Prepare statement error: " . $conn->error;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <style type="text/css">
   
        body {
        background-image: url('images/macarons.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif; /* Set Arial as the default font for the entire page */
         font-size: 16px; 
    }

    /* Increase the base font size for larger screens (adjust as needed) */
    @media screen and (min-width: 768px) {
        body {
            font-size: 18px;
        }
    }


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

    #content {
        background-color: rgba(255, 255, 255, 0.0);
        color: #000;
        padding: 20px;
        margin-top: 70px;
        display: flex; /* Display children (cards) in a row */
        justify-content: center; /* Center the cards horizontally */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.0);

    }


    .card {
    background-color: rgba(255, 255, 255, 0.9);
    padding: 5px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    text-align: center;
    width: calc(52% - 15px); /* Increase the width by 2% */
    margin: 0 10px; /* Add margin to the right and left of each card */
     font-size: 1rem; /* Responsive font size for cards */
}

.card:hover {
    transform: scale(1.1); /* Increase the scale (zoom in) on hover */
    transition: transform 0.3s ease; /* Add a smooth transition effect */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.7); /* Apply shadow on hover */

}


.card {
    
    transition: transform 0.3s ease; /* Smooth transition for both hover and non-hover states */
}

.card:hover {
    transform: scale(1.1); /* Increase the scale (zoom in) on hover */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.7); /* Apply shadow on hover */
}






  .card3 {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 5px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        text-align: center;
        width: calc(52% - 15px); /* Increase the width by 2% */
        margin: 180px 10px 0; /* Add margin at the top */
        font-size: 1rem; /* Responsive font size for cards */
        clear: both; /* Move to a new line */
    }

    .card3:hover {
        transform: scale(1.1);
        transition: transform 0.3s ease;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
    }

.card3 {
    
    transition: transform 0.3s ease; /* Smooth transition for both hover and non-hover states */
}

.card3:hover {
    transform: scale(1.1); /* Increase the scale (zoom in) on hover */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.7); /* Apply shadow on hover */
}







 .profile-card {
    background: linear-gradient(to top, rgba(200, 200, 200, 2), rgba(255, 255, 255, 1));
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    text-align: left;
    width: calc(20% - 20px); /* Adjust the width to control card spacing */
    margin: 0 10px; /* Add margin to the right and left of each card */
    font-family: Arial, sans-serif; /* Apply the Arial font */
     font-size: 1rem; /* Responsive font size for cards */
}


    /* Override link styles to make them look like normal text */
    .profile-card a {
        color: inherit; /* Inherit the text color from the parent */
        text-decoration: inherit; /* Inherit the text decoration from the parent */
    }











 .coater-card {
            background: linear-gradient(to top, rgba(200, 200, 200, 0.9), rgba(255, 255, 255, 1));
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: left;
            width: calc(35% - 20px); /* Adjust the width to control card spacing */
            margin: 0 10px; /* Add margin to the right and left of each card */
            font-size: 1rem; /* Responsive font size for cards */
        }



.chart-card {
            background: linear-gradient(to top, rgba(200, 200, 200, 0.9), rgba(255, 255, 255, 1));
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: left;
            width: calc(35% - 20px); /* Adjust the width to control card spacing */
            margin: 0 10px; /* Add margin to the right and left of each card */
            font-size: 1rem; /* Responsive font size for cards */
        }




       
        .card h1 {
            font-size: 24px;
            margin: 10px 0;
        }

        .card p {
            font-size: 16px;
            margin: 5px 0;
        }

/* Remove underline from links */
  .card.profile-card a {
    text-decoration: none;
    color: #007bff; /* Change link color to your preference */
  }


   .card.profile-card h1,
  .card.profile-card p {
    margin: 0;
    font-family: Arial, sans-serif; /* Choose your desired font-family */
    color: #333; /* Text color */
  }

 #coatercard {
        margin-top: -60px;
        margin-left: 218px;
        padding-bottom: 5px;
    }





     .card {
    overflow: hidden;
}

.slider {
    display: flex;
    overflow-x: scroll;
    scroll-snap-type: x mandatory;
}

.card-item {
    flex: 0 0 auto;
    scroll-snap-align: start;
    width: 98%;
    padding: 5px;
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


    </style>
</head>
<body>

<div id="content">
 <div class="card profile-card" onclick="redirectToProfile()" data-action="Profile Click">
    


    <div class="useravatar">
                <?php if (!empty($username)){
                    echo '<img src="/images/emp/'.$username.'.JPG" alt="User Avatar">';
                }
                else{
              
                    echo '<img src="/images/avatar.jpg" alt="Placeholder">';
                 }
                

                 ?>

                 <script type="text/javascript">
                 function displayUserAvatar($username) {
    $avatarPath = "/images/emp/{$username}.JPG";
    
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

    <h1>Welcome!</h1>
    <p style="font-size:12px;"><?php echo $employeeName; ?></p>
    <p><?php echo $username; ?></p>
    <p style="font-size:12px;"><b><?php echo $Dept; ?></b></p> 
</div>



<script>
   



    function redirectToProfile() {
        // Redirect to profile.php
        window.location.href = 'profile.php';
    }

    function recordAction(clickedElement) {
        // Get the action from the data attribute
        var action = clickedElement.getAttribute("data-action");

        // Send the action data to the server to record in the audit trail
        sendAuditTrail(action);
    }

    function sendAuditTrail(action) {
        // Use AJAX or another method to send the action to the server
        // Here's a basic example using fetch:
        fetch('record_audit.php', {
            method: 'POST',
            body: JSON.stringify({ action: action }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                // Successfully recorded in the audit trail
            } else {
                // Handle the error if recording fails
            }
        })
        .catch(error => {
            // Handle any network or other errors
        });
    }
</script>

   <div class="card coater-card" data-action="Coating Click">
    <h1>Coating Production</h1>
   <!--  <a href="recording.php">
        
    </a> -->


  <?php
                            if ($user_role === "Coating Recorder" || $user_role === "Coating Supervisor" || $user_role === "Super Admin") {
                             echo '<a href="recording.php"><img id="coatercard" src="images/add.png" style="width: 50px; height: 50px;"></a>';
                            }

                         ?>




    <!--  <button id="prev-button">Previous</button>
        <button id="next-button">Next</button> -->
    <div class="slider">
         <div class="card-item">
    <div id="coater-card-content">
        <?php include 'cards.php'; ?>
    </div>
</div>

 <div class="card-item">
    <div id="coater-card-content">
      <?php include 'smallchart.php'; ?>
    </div>
</div>

<div class="card-item">
  
    <div id="coater-card-content">
        <div>
             <?php include 'usercards.php'; ?>
        </div>
    </div>
</div>


<!-- <div class="card-item">
    <div id="coater-card-content">
        4th slide
    </div>
</div>
 -->



</div>






</div>

<script>
        // JavaScript for the slider
        const slider = document.querySelector('.slider');
        const cardItems = document.querySelectorAll('.card-item');

        let currentIndex = 0;

        function slideTo(index) {
            if (index >= 0 && index < cardItems.length) {
                currentIndex = index;
                slider.style.transform = `translateX(-${currentIndex * 120}%)`;
            }
        }

        // Add event listeners for navigation
        document.getElementById('next-button').addEventListener('click', () => {
            slideTo(currentIndex + 1);
        });

        document.getElementById('prev-button').addEventListener('click', () => {
            slideTo(currentIndex - 1);
        });
    </script>
<script>
    // Function to refresh the content every 2 seconds
    function refreshCoaterCard() {
        // Load the content using AJAX
        fetch('cards.php') // Replace 'cards.php' with the actual URL that returns the updated content
            .then(response => response.text())
            .then(data => {
                // Update the content inside the coater-card
                document.getElementById('coater-card-content').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Refresh the content every 2 seconds
    setInterval(refreshCoaterCard, 1000);
</script>




















<div class="card3 sales-card" data-action="" hidden>
    <h1>Containers</h1>
   


                       <!--  <?php
                            if ($user_role === "Sales" || $user_role === "Sales Manager" || $user_role === "Super Admin") {
                                echo '<a href="#"><img id="coatercard" src="images/add.png" style="width: 50px; height: 50px;"></a>';
                                }

                         ?> -->



   
</div>

</div>




</body>
</html>
