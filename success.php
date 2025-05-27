<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if (!$order_id) {
    die("Order ID missing! Please check your order history.");
}

// Connect to database
$conn = mysqli_connect('127.0.0.1', 'root', '', 'furn') or die("Database Connection Error!");

// ✅ Fetch Order Details
$order_query = "SELECT * FROM orders WHERE id = '$order_id'";
$order_result = mysqli_query($conn, $order_query);

if (mysqli_num_rows($order_result) == 0) {
    die("Invalid Order ID! Order not found.");
}

$order = mysqli_fetch_assoc($order_result);

// ✅ Fetch Ordered Items from `order_items` table
$order_items_query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
$order_items_result = mysqli_query($conn, $order_items_query);

$message = "Your order has been placed successfully!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="success.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<div class="success-container">
    <div class="success-card">
        <i class="fa fa-check-circle success-icon"></i>
        <h1>🎉 Order Confirmed! 🎉</h1>
        <p class="order-message"><?php echo $message; ?></p>

        <!-- ✅ Order Summary -->
        <div class="order-summary">
            <h2>Order Summary</h2>
            <div class="summary-box">
                <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
                <p><strong>Delivery Address:</strong> <?php echo $order['address']; ?></p>
                <hr>
                <h3>Ordered Items:</h3>
                <ul>
                    <?php while ($item = mysqli_fetch_assoc($order_items_result)) { ?>
                        <li>
                            <div class="item-row">
                                <div class="item-details">
                                    <span class="item-name"><?php echo $item['model']; ?></span>
                                    <span class="item-quantity">x<?php echo $item['quantity']; ?></span>
                                    <span class="item-price">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <hr>
                <p class="total-price"><strong>Total Paid:</strong> ₹<?php echo number_format($order['total_price'] / 100, 2); ?></p>
            </div>
        </div>

        <!-- ✅ Button to Continue Shopping -->
        <a href="product.php" class="continue-btn">🛍️ Continue Shopping</a>
    </div>
</div>

</body>
</html>
