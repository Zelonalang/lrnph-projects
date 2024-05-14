<?php
if (isset($_POST['reg-username']) && isset($_POST['reg-password']) && isset($_POST['reg-biometricno']) && isset($_POST['reg-role'])) {
  $regUsername = $_POST['reg-username'];
  $regPassword = $_POST['reg-password'];
  $regBiometricno = $_POST['reg-biometricno'];
  $regRole = $_POST['reg-role'];

  $db_host = 'localhost';
  $db_user = 'itadmin';
  $db_pass = 'La.rose1@)@!';
  $db_name = 'lrnphdev';

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Hash the password before storing it in the database
  $hashedPassword = password_hash($regPassword, PASSWORD_DEFAULT);

  $sql = "INSERT INTO sysusers (username, password, biometricno, role, online_status, avatar_path) VALUES ('$regUsername', '$hashedPassword', '$regBiometricno', '$regRole' , 'Logged Out', '0')";

  if (mysqli_query($conn, $sql)) {
    // Redirect to login.php after successful registration
    header("Location: systemsettings.php");
    exit(); // Make sure to exit after redirection
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}
?>
