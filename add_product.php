<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'furn') or die("Database Connection Error!");

$categoryQuery = "SELECT DISTINCT category FROM details";
$categoryResult = mysqli_query($conn, $categoryQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img = mysqli_real_escape_string($conn, $_POST['img']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $dimensions = mysqli_real_escape_string($conn, $_POST['dimensions']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $material = mysqli_real_escape_string($conn, $_POST['material']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    // Insert data into database
    $query = "INSERT INTO details (img, model, description, color, dimensions, price, material, category) VALUES ('$img', '$model', '$description', '$color', '$dimensions', '$price', '$material', '$category')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Product added successfully!'); window.location='manage_products.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
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

    <div class="main-content">
        <div class="profile-header">
            <h1>Add New Product</h1>
        </div>
        
        <div class="container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php while ($row = mysqli_fetch_assoc($categoryResult)) { ?>
                            <option value="<?php echo htmlspecialchars($row['category']); ?>">
                                <?php echo htmlspecialchars($row['category']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Image URL</label>
                    <input type="text" class="form-control" name="img" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control" name="description" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" class="form-control" name="color" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dimensions</label>
                    <input type="text" class="form-control" name="dimensions">
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Material</label>
                    <input type="text" class="form-control" name="material" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</body>
</html>
