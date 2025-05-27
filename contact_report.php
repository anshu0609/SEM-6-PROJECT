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

$query = "SELECT * FROM admin WHERE name = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$str="select * from contact";
$res=mysqli_query($conn,$str);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
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
            <li><a href="admin.php">Sales Report</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="orders.php">Orders History</a></li>
            <li><a href="#" class="active">Contact Report</a></li>
        </ul>
        <div class="bottom-links">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-header">
            <h1>Welcome, <?php echo$user['name']; ?>!</h1>
            <p></p>
        </div>
        
        <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h1 align="left">Contact Details</h1>
                    </div>
                </div>
                <br/>

                <table class="table table-bordered">
                    <thead> 
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Suject</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row=mysqli_fetch_array($res)) { ?>
                            <tr>
                                <td><?php echo ($row['name']); ?></td>
                                <td><?php echo ($row['email']); ?></td>
                                <td><?php echo ($row['subject']); ?></td>
                                <td><?php echo ($row['message']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
    </div>
</body>
</html>