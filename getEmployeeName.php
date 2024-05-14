<?php
// Replace with your actual database credentials
$host = "localhost";
$username = "itadmin";
$password = "La.rose1@)@!";
$database = "lrnphdev";

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Replace with your session handling logic
// For example, if you're using user IDs in sessions, you can replace '$_SESSION['username']' with '$_SESSION['user_id']'
$sessionValue = $_SESSION['username'];

// Prepare and execute a SQL query to retrieve the employee's name
$query = "SELECT EmployeeName FROM employeeinfo WHERE EmployeeID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $sessionValue);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $employeeName);

// Fetch the result
if (mysqli_stmt_fetch($stmt)) {
    $data = [
        'employeeName' => $employeeName,
    ];
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Employee not found']);
}

// Close the database connection
mysqli_close($conn);
?>
