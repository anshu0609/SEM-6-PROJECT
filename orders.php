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

// Query for fetching admin details
$query = "SELECT * FROM admin WHERE name = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Query to get order details
$orderQuery = "SELECT * FROM orders ORDER BY order_date DESC";
$orderResult = mysqli_query($conn, $orderQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="https://preview.colorlib.com/theme/furn/assets/img/logo/logo.png" alt="">
        </div>
        <ul>
            <li><a href="admin.php">Sales Report</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="orders.php" class="active">Orders History</a></li>
            <li><a href="contact_report.php">Contact Report</a></li>
        </ul>
        <div class="bottom-links">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-header">
            <h1>Welcome, <?php echo $user['name']; ?>!</h1>
            <p>View Order History</p>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>Order History</h1>
                </div>
            </div>
            <br/>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($orderResult)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td>&#8377;<?php echo number_format($row['total_price'], 2); ?></td>
                            <td><?php echo $row['payment_method']; ?></td>
                            <td><?php echo $row['order_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
