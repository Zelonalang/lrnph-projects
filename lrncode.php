<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_data"])) {
    $servername = "localhost";
    $username = "itadmin";
    $password = "La.rose1@)@!";
    $dbname = "lrnphdev";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize a flag to check if any record failed to insert
    $successFlag = true;

    // Iterate through the submitted rows and insert data into the database
    foreach ($_POST['boxQty'] as $key => $value) {
        $customerCode = $_POST['customerCode'][$key];
        $lrnItemCodes = $_POST['lrnItemCodes'][$key];
        $description = $_POST['description'][$key];
        $shelfLife = $_POST['shelfLife'][$key];
        $weight = $_POST['weight'][$key];
        $qtyPerBox = $_POST['qtyPerBox'][$key];
        $boxType = $_POST['boxType'][$key];
        $boxQty = $_POST['boxQty'][$key];
        $poNumber = $_POST['ponumber'][$key];
        $fortyftb = $_POST['fortyftb'][$key];
        $twentyftb = $_POST['twentyftb'][$key];
        $fortyftContainer = $_POST['fortypallet'][$key];
        $twentyftContainer = $_POST['twentypallet'][$key];
        $actionBy = $_POST['actionby'];
        $suggested = $_POST['suggested'];
        


        // Perform the insertion query
        $sql = "INSERT INTO `scontainer` (`customerCode`, `lrnItemCodes`, `description`, `shelfLife`, `weight`, `qtyPerBox`, `boxType`, `boxQty`, `ponumber`, `fortyftb`, `twentyftb`, `fortypallet`, `twentypallet`, `actionby`, `suggested`) VALUES ('$customerCode', '$lrnItemCodes', '$description', '$shelfLife', '$weight', '$qtyPerBox', '$boxType', '$boxQty', '$poNumber', '$fortyftb', '$twentyftb', '$fortyftContainer', '$twentyftContainer', '$actionBy', '$suggested')";

        if ($conn->query($sql) !== TRUE) {
            // If any record fails to insert, set the flag to false
            $successFlag = false;
            break; // Break the loop if there is an error
        }
    }

    // Close the connection
    $conn->close();

    // Check the flag to determine if all records were inserted successfully
    if ($successFlag) {
        // Redirect to testxls.php
        header("Location: testxls.php");
        exit; // Ensure that the script stops executing after the redirect
    } else {
        // Handle the case where at least one record failed to insert
        echo "Error inserting records. Please try again.";
    }
}
?>
    