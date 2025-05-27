<?php
use Razorpay\Api\Api;
session_start();
require __DIR__ . '/vendor/autoload.php';
$conn = mysqli_connect('127.0.0.1', 'root', '', 'furn') or die("Database Connection Error!");

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user email
$user_query = "SELECT email FROM register WHERE name = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_email = $user['email'];

// Fetch cart items
$cart_query = "SELECT * FROM cart WHERE email = '$user_email'";
$cart_result = mysqli_query($conn, $cart_query);

// Calculate total price
$total_price_query = "SELECT SUM(price * quantity) AS total FROM cart WHERE email = '$user_email'";
$total_result = mysqli_query($conn, $total_price_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_price = $total_row['total'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    
    if ($payment_method == "COD") {
        // Insert order details into database
        $order_query = "INSERT INTO orders (username, email, total_price, payment_method, status) VALUES ('$username', '$user_email', '$total_price', 'COD', 'Pending')";
        mysqli_query($conn, $order_query);
        
        // Clear cart
        mysqli_query($conn, "DELETE FROM cart WHERE email = '$user_email'");
        
        header("Location: success.php?method=COD");
        exit();
    }
    
    if ($payment_method == "Online") {
        $key_id = 'rzp_test_aLHKTTr5lTqLYS';
        $key_secret = 'b3gsP6RBENZb2ACOmUSXbU5b';
        
        $api = new Api($key_id, $key_secret);
        
        $orderData = [
            'receipt' => 'FURN_' . time(),
            'amount' => $total_price * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ];
        
        $order = $api->order->create($orderData);
        $order_id = $order['id'];
        
        echo json_encode(["order_id" => $order_id]);
        exit();
    }
}
?>
