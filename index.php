<?php
session_start();

// Check if the user is already logged in, if yes, redirect to another page
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You should validate and sanitize user input here

    // Perform authentication (you should replace this with your own authentication logic)
    if ($username === 'your_username' && $password === 'your_password') {
        // Authentication successful, store the username in the session
        $_SESSION['username'] = $username;
        // Redirect to the dashboard or another page
        header('Location: dashboard.php');
        exit;
    } else {
        // Authentication failed, show an error message
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>La Rose Noire</title>

    <style type="text/css">
        body {
            background-image: url('images/macarons.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .login-container h2 {
            text-align: center;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .login-form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form button {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" method="post" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php
        // Display error message if authentication failed
        if (isset($error_message)) {
            echo "<p>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
 