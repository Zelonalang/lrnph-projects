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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $userId = $_POST["editUserId"];
    $newUsername = $_POST["editUsername"];
    $newPassword = $_POST["editPassword"];
    $newBiometricNo = $_POST["editBiometricNo"];
    $newRole = $_POST["editRole"];
    $newOnlineStatus = $_POST["editOnlineStatus"];
    $newAvatarPath = $_POST["editAvatarPath"];
    
    // Hash the new password before storing it in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // SQL query to update user data
    $sql = "UPDATE `sysusers` SET `username` = ?, `password` = ?, `biometricno` = ?, `role` = ?, `online_status` = ?, `avatar_path` = ? WHERE `userid` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissii", $newUsername, $hashedPassword, $newBiometricNo, $newRole, $newOnlineStatus, $newAvatarPath, $userId);

    if ($stmt->execute()) {
        // Update successful
        echo "User data updated successfully.";
    } else {
        // Handle the error
        echo "Error updating user data: " . $stmt->error;
    }
}

// Close the database connection
$conn->close();
?>
