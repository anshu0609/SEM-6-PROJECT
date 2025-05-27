<?php
session_start();
$conn = new mysqli('127.0.0.1', 'root', '', 'furn');

if ($conn->connect_error) {
    die("Database Connection Error!");
}

if (isset($_POST['formsubmit'])) {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $userType = $_POST['usertype'] ?? 'Client';

    if ($userType === 'Admin') {
        $stmt = "SELECT * FROM admin WHERE email = '$email' AND pass = '$pass'";
    } else {
        $stmt = "SELECT * FROM register WHERE email = '$email' AND pass = '$pass'";
    }

    $result = mysqli_query($conn, $stmt);
    $row = mysqli_fetch_array($result);
    $name = $row['name'] ?? null;

    if ($name) {
        $_SESSION['username'] = $name; 
        $_SESSION['usertype'] = $userType;

        $redirectPage = ($userType === 'Admin') ? 'admin.php' : 'home.php';
        header("Location: $redirectPage");
        exit();
    } else {
        echo "<script>alert('Invalid Email Address or Password!!!');</script>";
    }
}
$conn->close();
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

    <script>
    function selectLabel(labelId) {
        document.getElementById('client').classList.remove('selected');
        document.getElementById('admin').classList.remove('selected');
        document.getElementById(labelId).classList.add('selected');

        document.getElementById(labelId + "-radio").checked = true;

        if (labelId === 'admin') {
            document.getElementById("email").value = "admin@furn.com";
            document.getElementById("email").setAttribute("readonly", "readonly");
        } else {
            document.getElementById("email").value = "";
            document.getElementById("email").removeAttribute("readonly");
        }
    }
    </script>
    <style>
        .label-option {
            cursor: pointer;
            padding: 8px 15px;
            font-weight: 600;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease-in-out;
        }

        .selected {
            background-color: #ff6600;
            color: white;
        }

        input[type="radio"] {
            display: none;
        }
    </style>

</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <p>Enter your login details to get access</p>

            <form method="POST">
            <div class="text-center">
                <label class="label-option selected" id="client" onclick="selectLabel('client')">
                    <input type="radio" name="usertype" value="Client" id="client-radio" checked> Client
                </label> 
                | 
                <label class="label-option" id="admin" onclick="selectLabel('admin')">
                    <input type="radio" name="usertype" value="Admin" id="admin-radio"> Admin
                </label>
            </div>

            
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Email address" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="pass" placeholder="Enter Password" required>
                </div>
                
                <button type="submit" name="formsubmit">Login</button>
                
                <p class="signup-text">Don’t have an account? <a href="register.php">Sign Up</a> here</p>
            </form>
        </div>
    </div>
</body>
</html>
