<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
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

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO scontainer (lrn_code, description, pcs_box, box_order, po_number, 40ft, 20ft, up17mx, up8mx, actionby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $lrnCode, $description, $pcsBox, $boxOrder, $poNumber, $c40ft175lp, $c20ft8lp, $c40ftUsedPallet, $c20ftUsedPallet, $actionBy);

    // Loop through the submitted form data
    foreach ($_POST['lrncode'] as $key => $value) {
        $lrnCode = $value;
        $description = $_POST['description'][$key];
        $pcsBox = $_POST['pcsbox'][$key];
        $boxOrder = $_POST['boxorder'][$key];
        $poNumber = $_POST['ponumber'][$key];
        $c40ft175lp = $_POST['c40ft175lp'][$key];
        $c20ft8lp = $_POST['c20ft8lp'][$key];
        $c40ftUsedPallet = $_POST['c40ftusedpallet'][$key];
        $c20ftUsedPallet = $_POST['c20ftusedpallet'][$key];
        $actionBy = $_POST['actionby'][$key]; // Retrieve actionby value

        // Execute the SQL statement
        $stmt->execute();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a thank you page or any other page after successful submission
    header("Location: sales_management.php");
    exit();
}
?>
