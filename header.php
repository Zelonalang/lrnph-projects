<?php
// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username']) || !isset($_SESSION['user_role']) || !isset($_SESSION['employeeName']) ) {
    header('Location: login.php');
    exit;
}

// You can access user information like username and user_role from the session as needed
$username = $_SESSION['username'];
$user_role = $_SESSION['user_role'];
$employeeName = $_SESSION['employeeName'];

?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>La Rose Noire</title>
    <style>
        /* Reset default margin and padding for all elements */
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; /* Set Arial as the font for all elements */
        }

        /* CSS styles for the header */
        header {
            background-color: rgba(51, 51, 51, 0.5); /* Background color with reduced opacity */
            color: #fff; /* Text color */
            padding: 1px; /* Padding around the header content */
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Vertically align items in the center */
            backdrop-filter: blur(5px); /* Apply a 5px blur to the background */
        }

        header h1 {
            font-size: 20px; /* Font size for the page title */
            flex-grow: 1; /* Allow the title to grow and take available space */
        }

        nav ul {
            list-style-type: none; /* Remove bullet points from the list */
            padding: 0; /* Remove default padding from the list */
            text-align: right; /* Right-align the list items */
            margin-right: 10px;
        }

        nav li {
            display: inline; /* Display list items horizontally */
            margin-left: 10px; /* Add spacing between list items */
        }

        nav a {
            text-decoration: none; /* Remove underline from links */
            color: #fff; /* Text color for links */
        }

        /* CSS styles for the logo */
        .logo {
            max-width: 40px; /* Resize the logo to a specific width */
            margin-right: 10px; /* Add spacing to the right of the logo */
            margin-left: 10px;
        }

        /* Styles for the avatar */
        .avatar {
            width: 32px; /* Adjust the avatar width as needed */
            height: 32px; /* Adjust the avatar height as needed */
            border-radius: 50%; /* Make the avatar circular */
            background-image: <?php echo "url('images/emp/".$username.".JPG')"; ?>; /* Replace with the path to your avatar image */
            background-size: cover;
            background-position: center;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
         /* Styles for the avatar */
        .avatar1 {
            width: 32px; /* Adjust the avatar width as needed */
            height: 32px; /* Adjust the avatar height as needed */
            border-radius: 5%; /* Make the avatar circular */
            background-image: url('images/reports.png'); /* Replace with the path to your avatar image */
            background-size: cover;
            background-position: center;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

 /* Styles for the avatar */
        .avatar2 {
            width: 32px; /* Adjust the avatar width as needed */
            height: 32px; /* Adjust the avatar height as needed */
            border-radius: 5%; /* Make the avatar circular */
            background-image: url('images/analytics.png'); /* Replace with the path to your avatar image */
            background-size: cover;
            background-position: center;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        /* Styles for the avatar */
        .avatar3 {
            width: 32px; /* Adjust the avatar width as needed */
            height: 32px; /* Adjust the avatar height as needed */
            border-radius: 5%; /* Make the avatar circular */
            background-image: url('images/trans.png'); /* Replace with the path to your avatar image */
            background-size: cover;
            background-position: center;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }


       /* Dropdown menu styles */
    .dropdown {
        position: relative;
        display: inline-block;
        cursor: pointer; /* Add cursor pointer to indicate clickability */
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #333; /* Background color for the dropdown menu */
        min-width: 160px;
        z-index: 1;
        right: 0; /* Align the dropdown to the right */
    }

    .dropdown-content a {
        color: #fff;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #555; /* Background color for the hovered item */
    }

    /* JavaScript to toggle dropdown on click */
    .dropdown.active .dropdown-content {
        display: block;
    }

        /* Make the navigation responsive */
        @media screen and (max-width: 600px) {
            header {
                flex-direction: column; /* Stack header items vertically */
                text-align: center; /* Center-align header items */
            }

            nav ul {
                margin-top: 10px; /* Add spacing between logo and navigation on small screens */
                text-align: center; /* Center-align navigation items */
            }

            nav li {
                display: block; /* Display list items as block elements */
                margin-left: 0; /* Remove margin between list items */
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="images/rose.png" alt="Website Logo" class="logo" onclick="redirectTodashboard()"> <!-- Replace "images/rose.png" with the path to your actual logo image -->
        <h1 onclick="redirectTodashboard()">La Rose Noire</h1>
        <script>
   function redirectTodashboard() {
      // Redirect to profile.php
      window.location.href = 'dashboard.php';
   }



</script>
        <nav>
            <ul>


                
                <li class="dropdown">
                    <div class="avatar3"></div> <!-- Replace with your avatar image -->
                       <div class="dropdown-content">
    <?php
    // Assuming $user_role is defined somewhere before this code snippet
    if (isset($user_role)) {
        if ($user_role === "Coating Recorder" || $user_role === "Coating Supervisor" || $user_role === "Super Admin") {
            echo '<a href="recording.php">Coating Production</a>';
        }
    }
           ?>



<?php
                            if ($user_role === "Sales" || $user_role === "Super Admin" || $user_role === "Sales Manager") {
                             echo '<a href="testxls.php">Containers</a>';
                            }

                         ?>


<?php
                            if ($user_role === "Sales" || $user_role === "Super Admin" || $user_role === "Sales Manager") {
                             echo '<a href="uploadfile.php">Upload Product list</a>';
                            }

                         ?>


                        </div>

                </li>
               <li class="dropdown">
                    <div class="avatar2"></div> <!-- Replace with your avatar image -->
                    <div class="dropdown-content">
                     

                          <?php
                            if ($user_role === "Coating Supervisor" || $user_role === "Super Admin") {
                                echo '<a href="graphs.php">Coating Charts/Stats</a>';
                            }
                                
                         ?>
                       <!--  <a href="piechart.php">Others</a> -->
                       <!--  <a href="#"></a>
                        <a href="#"></a> -->
                    </div>
                </li>
                <li class="dropdown">
                    <div class="avatar1"></div> <!-- Replace with your avatar image -->
                    <div class="dropdown-content">
                       <!--  <a href="shiftreport.php">Coating Reports</a> -->


                         <?php
                            if ($user_role === "Coating Supervisor" || $user_role === "Super Admin") {
                                echo '<a href="shiftreport.php">Coating Reports</a>';
                            }
                               
                         ?>



                        <?php
                            if ($user_role === "Sales" || $user_role === "Super Admin" || $user_role === "Sales Manager") {
                             echo '<a href="containerlist.php">PO List</a>';
                            }

                         ?>


                       <!--  <a href="#">Others</a>
                        <a href="#">Others</a>
                        
                        <a href="#">Others</a> -->
                    </div>
                </li>
                <!-- Add a unique ID to the last dropdown to make it easier to hide -->
               <li class="dropdown" id="userDropdown">
    <div class="avatar"></div>
    <div class="dropdown-content">
        <a href="profile.php">Account</a>
        <?php
        if ($user_role === "Super Admin") {
            echo '<a href="systemsettings.php">System Settings</a>';
        }
        ?>

         <?php
        if ($user_role === "Super Admin") {
            echo '<a href="jtbv.php">DB Tables</a>';
        }
        ?>



         <?php
        if ($user_role === "Coating Supervisor") {
            echo '<a href="coatermngmnt.php">Manage Coating</a>';
        }
        ?>
        <a href="logout.php">Logout</a>
        <a href="tutspage.php"><img id="infoImage" src="images/question.png" alt="Info" style="width: 30px; height: 30px; margin-top: 1px;"></a>
    </div>
</li>
            </ul>
        </nav>
    </header>


    <!-- Rest of your web page content goes here -->
<script>
    // JavaScript to toggle the dropdown on click
    function toggleDropdown(dropdown) {
        dropdown.classList.toggle("active");
    }

    // Add click event listeners to dropdowns
    var dropdowns = document.querySelectorAll('.dropdown');
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener('click', function () {
            toggleDropdown(this);
        });
    }

    // Close dropdowns when clicking outside
    window.addEventListener('click', function (e) {
        for (var i = 0; i < dropdowns.length; i++) {
            var dropdown = dropdowns[i];
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove("active");
            }
        }
    });
</script>
</body>
</html>
