<?php
session_start();
	#connect to the database
	$conn=mysqli_connect('127.0.0.1','root','','furn') or die("Database Connection Error!");
    if (isset($_POST['formsubmit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $confirm = $_POST['confirm'];
    
        if ($pass === $confirm) {
            $str = "INSERT INTO register (name, email, pass) VALUES ('$name', '$email', '$pass')";
            if (mysqli_query($conn, $str)) {
                echo "<script>alert('Registration successful!');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="login-container">
<div class="login-box">
            <h2>Sign Up</h2>
            <p>Create for account to get access</p>
            <form method="POST">
                <div class="input-group">
                    <label for="username">Name</label>
                    <input type="text" name="name" placeholder="Enter Name" required>
                </div>
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="pass" placeholder="Enter Password" required>
                </div>

                <div class="input-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="confirm" placeholder="Re - Enter Password" required>
                </div>
                
                <button type="submit" name="formsubmit">Sign Up</button>
                
                <p class="signup-text">Already have an account? <a href="login.php">Login</a> here</p>
            </form>
        </div>
</div>
</body>
</html>
