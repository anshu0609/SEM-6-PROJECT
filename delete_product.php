<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'furn') or die("Database Connection Error!");

if (isset($_GET['model'])) {
    $model = mysqli_real_escape_string($conn, $_GET['model']);
    
    // Delete the product from the database
    $deleteQuery = "DELETE FROM details WHERE model = '$model'";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Product deleted successfully!'); window.location.href = 'manage_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product.'); window.location.href = 'manage_products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'manage_products.php';</script>";
}

mysqli_close($conn);
?>
