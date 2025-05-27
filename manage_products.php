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

// Fetch product details
$productQuery = "SELECT * FROM details";
$productResult = mysqli_query($conn, $productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
            <li><a href="manage_products.php" class="active">Manage Products</a></li>
            <li><a href="orders.php">Orders History</a></li>
            <li><a href="contact_report.php">Contact Report</a></li>
        </ul>
        <div class="bottom-links">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-header">
            <h1>Welcome, <?php echo$user['name']; ?>!</h1>
            <p>Manage Product Details</p>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>Product Details</h1>
                </div>
                <div class="col-md-4 text-end">
                    <a href="add_product.php" class="btn btn-success">Add Product</a>
                </div>
            </div>
            <br/>

            <table class="table table-bordered">
                <thead> 
                    <tr>
                        <th>Image</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Dimensions</th>
                        <th>Price</th>
                        <th>Material</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row=mysqli_fetch_array($productResult)) { ?>
                        <tr>
                            <td><img src="<?php echo $row['img']; ?>" width="50" height="50"></td>
                            <td><?php echo $row['model']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['color']; ?></td>
                            <td><?php echo $row['dimensions']; ?></td>
                            <td>&#8377;<?php echo $row['price']; ?></td>
                            <td><?php echo $row['material']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td>
                                <a href="edit_product.php?model=<?php echo $row['model']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_product.php?model=<?php echo $row['model']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
