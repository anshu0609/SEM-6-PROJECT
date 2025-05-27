<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'furn') or die("Database Connection Error!");

$query = "SELECT * FROM register WHERE name = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Furn</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="https://preview.colorlib.com/theme/furn/assets/img/logo/logo.png" alt="">
        </div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="bottom-links">
            <a href="editprofile.php">Edit Profile</a>
            <a href="delete.php">Delete Profile</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-header">
            <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p>Manage your account details and preferences.</p>
        </div>

        <div class="profile-card">
            <table>
                <tr><th>Name:</th><td><?php echo htmlspecialchars($user['name']); ?></td></tr>
                <tr><th>Email:</th><td><?php echo htmlspecialchars($user['email']); ?></td></tr>
                <tr><th>Phone:</th><td><?php echo htmlspecialchars($user['mobile']); ?></td></tr>
                <tr><th>Address:</th><td><?php echo htmlspecialchars($user['address']); ?></td></tr>    
            </table>
        </div>

        <div class="profile-actions">
            <h3>Order History</h3>
            <p>View and manage your past orders.</p>
            <a href="order_history.php" class="btn btn-primary">View Order History</a>
        </div>
    </div>
</body>
</html>
