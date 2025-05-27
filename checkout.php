<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

$conn = mysqli_connect('127.0.0.1', 'root', '', 'furn') or die("Database Connection Error!");

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user details (including address)
$user_query = "SELECT email, mobile, address FROM register WHERE name = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_email = $user['email'];
$user_mobile = $user['mobile'];
$user_address = $user['address']; // Saved address (if available)

// Fetch cart items
$cart_query = "SELECT * FROM cart WHERE email = '$user_email'";
$cart_result = mysqli_query($conn, $cart_query);

// Calculate total price
$total_price_query = "SELECT SUM(price * quantity) AS total FROM cart WHERE email = '$user_email'";
$total_result = mysqli_query($conn, $total_price_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_price = intval($total_row['total'] * 100); // Convert to paise for Razorpay

// ✅ Razorpay API Keys
use Razorpay\Api\Api;
$key_id = 'rzp_test_aLHKTTr5lTqLYS';  // Replace with your actual key
$key_secret = 'b3gsP6RBENZb2ACOmUSXbU5b';   // Replace with your actual secret key

$api = new Api($key_id, $key_secret);

$orderData = [
    'receipt'         => 'FURN_' . time(),
    'amount'          => $total_price, // Total amount from cart
    'currency'        => 'INR',
    'payment_capture' => 1 // Auto-capture
];

$order = $api->order->create($orderData);
$order_id = $order['id'];

// ✅ Handle COD Order Placement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $payment_method = $_POST['payment_method'];
    $new_address = mysqli_real_escape_string($conn, $_POST['address']);

    // ✅ Update address if changed
    if (!empty($new_address) && $new_address !== $user_address) {
        $update_address_query = "UPDATE register SET address='$new_address' WHERE email='$user_email'";
        mysqli_query($conn, $update_address_query);
        $user_address = $new_address;
    }

    // ✅ If COD is selected, place order immediately
    if ($payment_method == "cod") {
        $order_query = "INSERT INTO orders (name, email, address, total_price, payment_method, order_date) 
                        VALUES ('$username', '$user_email', '$user_address', '$total_price', '$payment_method', NOW())";
        
        if (mysqli_query($conn, $order_query)) {
            $order_id = mysqli_insert_id($conn); // Get the new order ID

            // ✅ Insert order items
            $cart_query = "SELECT model, quantity, price FROM cart WHERE email = '$user_email'";
            $cart_result = mysqli_query($conn, $cart_query);

            while ($item = mysqli_fetch_assoc($cart_result)) {
                $model = $item['model'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                $item_query = "INSERT INTO order_items (order_id, model, quantity, price) 
                               VALUES ('$order_id', '$model', '$quantity', '$price')";
                mysqli_query($conn, $item_query);
            }

            // ✅ Clear cart
            mysqli_query($conn, "DELETE FROM cart WHERE email = '$user_email'");

            // ✅ Redirect to success page
            header("Location: success.php?order_id=" . $order_id);
            exit();
        } else {
            echo "<script>alert('Error placing order! Please try again.');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<header>
    <h1>Checkout</h1>
</header>

<div class="checkout-container">
    <div class="order-summary">
        <h2>Order Summary</h2>
        <ul>
            <?php while ($row = $cart_result->fetch_assoc()) { ?>
                <li>
                    <span><?php echo $row['model']; ?> (x<?php echo $row['quantity']; ?>)</span>
                    <span>₹<?php echo number_format($row['price'] * $row['quantity'], 2); ?></span>
                </li>
            <?php } ?>
        </ul>
        <hr>
        <h3>Total: ₹<?php echo number_format($total_price / 100, 2); ?></h3>
    </div>

    <!-- Address Section -->
    <div class="address-section">
        <h2>Shipping Address</h2>
        <form method="POST" id="payment-form">
            <label for="address">Enter Address:</label><br>
            <textarea name="address" id="address" required><?php echo htmlspecialchars($user_address); ?></textarea><br>

            <h2>Choose Payment Method</h2>
            <input type="radio" name="payment_method" value="cod" id="cod" required>
            <label for="cod">Cash on Delivery (COD)</label><br>

            <input type="radio" name="payment_method" value="razorpay" id="razorpay" required>
            <label for="razorpay">Pay Online (Razorpay)</label><br>

            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

            <button type="submit" name="place_order" id="checkout-btn">Place Order</button>
        </form>
    </div>
</div>

<script>
document.getElementById("payment-form").addEventListener("submit", function(e) {
    var selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;

    if (selectedPayment === "razorpay") {
        e.preventDefault();
        var options = {
            "key": "<?php echo $key_id; ?>",
            "amount": "<?php echo $total_price; ?>",
            "currency": "INR",
            "name": "Furn Store",
            "description": "Order Payment",
            "order_id": "<?php echo $order_id; ?>",
            "handler": function (response) {
                window.location.href = "success.php?payment_id=" + response.razorpay_payment_id;
            },
            "prefill": {
                "name": "<?php echo $username; ?>",
                "email": "<?php echo $user_email; ?>",
                "contact": "<?php echo $user_mobile; ?>"
            },
            "theme": { "color": "#FD8F5F" },
            "modal": {
                "ondismiss": function() { alert('Payment cancelled!'); }
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    }
});
</script>

</body>
</html>
