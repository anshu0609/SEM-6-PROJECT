<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'furn') or die("Database Connection Error!");

// Check if model is provided
if (!isset($_GET['model'])) {
    die("Product model not specified.");
}

$model = $_GET['model'];

// Fetch product details
$query = "SELECT * FROM details WHERE model = '$model'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $color = $_POST['color'];
    $dimensions = $_POST['dimensions'];
    $price = $_POST['price'];
    $material = $_POST['material'];
    $category = $_POST['category'];
    
    $updateQuery = "UPDATE details SET 
                    description = '$description',
                    color = '$color',
                    dimensions = '$dimensions',
                    price = '$price',
                    material = '$material',
                    category = '$category'
                    WHERE model = '$model'";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        </ul>
        <div class="bottom-links">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1>Edit Product</h1>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" value="<?php echo $product['model']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" value="<?php echo $product['description']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" value="<?php echo $product['color']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dimensions</label>
                    <input type="text" name="dimensions" class="form-control" value="<?php echo $product['dimensions']; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Material</label>
                    <input type="text" name="material" class="form-control" value="<?php echo $product['material']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="<?php echo $product['category']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
</body>
</html>
