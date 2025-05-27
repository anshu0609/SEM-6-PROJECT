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

// Fetch sales data by product
$productQuery = "SELECT model, SUM(quantity) AS total_sales FROM order_items GROUP BY model";
$productResult = mysqli_query($conn, $productQuery);
$productData = [];
while ($row = mysqli_fetch_assoc($productResult)) {
    $productData[] = $row;
}

// Fetch sales data by category
$categoryQuery = "SELECT d.category, SUM(oi.quantity) AS total_sales 
                 FROM order_items oi
                 JOIN details d ON oi.model = d.model
                 GROUP BY d.category";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categoryData = [];
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categoryData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="https://preview.colorlib.com/theme/furn/assets/img/logo/logo.png" alt="">
        </div>
        <ul>
            <li><a href="#" class="active">Sales Report</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
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
            <p>Sales Report</p>
        </div>
        
        <div class="chart-container">
            <div class="chart-box">
                <h2>Sales Distribution by Product</h2>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="chart-box">
                <h2>Sales Distribution by Category</h2>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

    </div>
</body>
<script>
        const productData = <?php echo json_encode($productData); ?>;
        const productLabels = productData.map(item => item.model);
        const productSales = productData.map(item => item.total_sales);
        
        new Chart(document.getElementById('salesChart'), {
            type: 'pie',
            data: {
                labels: productLabels,
                datasets: [{
                    data: productSales,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#FD8F5F', '#1D2547'],
                }]
            }
        });
        
        const categoryData = <?php echo json_encode($categoryData); ?>;
        const categoryLabels = categoryData.map(item => item.category);
        const categorySales = categoryData.map(item => item.total_sales);
        
        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categorySales,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#FD8F5F', '#1D2547'],
                }]
            }
        });
    </script>
</html>
