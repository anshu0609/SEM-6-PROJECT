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

// Query to get user details based on the session username
$query = "SELECT * FROM register WHERE name = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Fetch user's order history based on the username
$orderQuery = "SELECT * FROM orders WHERE email = '" . $user['email'] . "' ORDER BY order_date DESC";
$orderResult = mysqli_query($conn, $orderQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Furn</title>
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
            <h1>Order History, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p>Here are your previous orders.</p>
        </div>

        <!-- Order History Table -->
        <div class="">
            <h2>Your Orders</h2>
            <?php if (mysqli_num_rows($orderResult) > 0) { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Address</th>
                            <th>Total Price</th>
                            <th>Payment Method</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($orderResult)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td>&#8377;<?php echo number_format($row['total_price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>You have not placed any orders yet.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
