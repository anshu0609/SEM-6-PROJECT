<?php
session_start();
$conn = mysqli_connect('127.0.0.1', 'root', '', 'furn') or die("Database Connection Error!");

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user email instead of ID
$user_query = "SELECT email FROM register WHERE name = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_email = $user['email'];

// ✅ Remove item from cart
if (isset($_POST['remove_item'])) {
    $model = $_POST['model'];
    $stmt = "DELETE FROM cart WHERE email = '$user_email' AND model = '$model'";
    mysqli_query($conn, $stmt);
    header("Location: cart.php"); // Refresh cart page
    exit();
}

if (isset($_POST['update_quantity'])) {
    $model = $_POST['model'];
    $action = $_POST['update_quantity']; // Now it correctly receives "plus" or "minus"

    // Fetch current quantity
    $query = "SELECT quantity FROM cart WHERE email = '$user_email' AND model = '$model'";
    $result = mysqli_query($conn, $query);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $current_quantity = $row['quantity'];

        // Update quantity based on action
        if ($action == "plus" && $current_quantity < 10) {
            $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE email = '$user_email' AND model = '$model'";
        } elseif ($action == "minus" && $current_quantity > 1) {
            $update_query = "UPDATE cart SET quantity = quantity - 1 WHERE email = '$user_email' AND model = '$model'";
        }

        // Execute update query if valid
        if (isset($update_query)) {
            mysqli_query($conn, $update_query);
        }
    }

    header("Location: cart.php"); // Refresh cart page
    exit();
}

// ✅ Fetch cart items for the user
$sql = "SELECT * FROM cart WHERE email = '$user_email'";
$result = $conn->query($sql);

// ✅ Calculate total price
$total_price_query = "SELECT SUM(price * quantity) AS total FROM cart WHERE email = '$user_email'";
$total_result = mysqli_query($conn, $total_price_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_price = $total_row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" href="cart.css">
        <link rel="stylesheet" href="product.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <script src="https://cdn.landbot.io/landbot-3/landbot-3.0.0.js"></script>
        <script>
            window.addEventListener('mouseover', initLandbot, { once: true });
            window.addEventListener('touchstart', initLandbot, { once: true });
            var myLandbot;
            function initLandbot() {
            if (!myLandbot) {
                var s = document.createElement('script');
                s.type = "module"
                s.async = true;
                s.addEventListener('load', function() {
                var myLandbot = new Landbot.Livechat({
                    configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-2795515-UKSFXQ1W26V9GKAW/index.json',
                });
                });
                s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.mjs';
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            }
}
</script>
</script>
    </head>
<body>

    <header>
        <div class="menu-bar">
            <i class="fas fa-bars"></i>
        </div>    
        <nav>
            
            <div class="navbar">

                <div class="p-items">
                    <div class="logo">
                        <img src="https://preview.colorlib.com/theme/furn/assets/img/logo/logo.png" alt="">
                    </div>
                    <ul>
                            <a href="home.php"><li>Home</li></a>
                            <a href="product.php"><li>Product</li></a>
                            <a href="About.php"><li>About</li></a>
                            <a href="register.php"><li>Register</a></li>
                            <a href="blog.php"><li>Blog</li</a>
                            <a href="Contact.php"><li>Contact</li></a>
                        </ul>
                    </div>

                    <div class="p-cart">
                        <a href="profile.php">My Account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a> 
                    </div>
            </div>


        </nav>
        <div class="banner">
            <div class="banner-text">
                <h1>Products</h1>
                <p><a href="">Home </a>> Product</p>
            </div>
        </div>

    </header>
    
    <div class="maincontainer">
    <h1>Your Cart</h1>
    
    <?php if ($result->num_rows > 0) { ?>
        <div class="cart-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="cart-item" id="product-<?php echo $row['model']; ?>">
                    <div class="cart-img">
                        <img src="<?php echo $row['img']; ?>" alt="">
                    </div>
                    <div class="cart-details">
                        <h3><?php echo $row['model']; ?></h3>
                        <p>Price: ₹<?php echo $row['price']; ?></p>

                        <div class="quantity-controls">
                            <form method="POST">
                                <input type="hidden" name="model" value="<?php echo $row['model']; ?>">
                                
                                <button type="submit" name="update_quantity" value="minus" class="qty-btn">-</button>
                                <span class="quantity"><?php echo $row['quantity']; ?></span>
                                <button type="submit" name="update_quantity" value="plus" class="qty-btn">+</button>
                            </form>
                        </div>

                        <form method="POST">
                            <input type="hidden" name="model" value="<?php echo $row['model']; ?>">
                            <button type="submit" class="cart-btn remove-btn" name="remove_item">Remove</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="cart-summary">
            <h2>Total: ₹<?php echo number_format($total_price, 2); ?></h2>
            <a href="checkout.php"><button class="checkout-btn">Proceed to Checkout</button></a>
        </div>
    <?php } else { ?>
        <p>Your cart is empty.</p>
    <?php } ?>
        <a class="continuebtn" href="product.php">Continue Shopping</a>
</div>

    <footer>

        <div class="upper-footer">
            <div class="footer-item">
                <i class="fa-solid fa-truck-fast"></i>
                <h3>Fast & Free Delivery</h3>
                <p>Enjoy fast and free delivery on all your orders, ensuring you get your products without any additional charges.</p>
            </div>

            <div class="footer-item">
                <i class="fa-solid fa-credit-card"></i>
                <h3>Secure Payment</h3>
                <p>Shop with confidence using our secure payment methods, designed to protect your transactions.</p>
            </div>

            <div class="footer-item">
                <i class="fa-solid fa-money-bill"></i>
                <h3>Money Back Guarantee</h3>
                <p>Not satisfied? We offer a hassle-free money-back guarantee for a worry-free shopping experience.</p>
            </div>

            <div class="footer-item">
                <i class="fa-solid fa-phone"></i>
                <h3>Online Support</h3>
                <p>Need help? Our dedicated online support team is available to assist you 24/7.</p>
            </div>


        </div>

        <div class="lower-footer">
            <div class="lower-footer-items">
                <img src="https://preview.colorlib.com/theme/furn/assets/img/logo/logo2_footer.png" alt="">
                <p>Your trusted partner for quality, convenience, and exceptional service."</p>

                <div class="social-media">
                        <a href="https://www.facebook.com/" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
        </div>

        <div class="lower-footer-items">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="https://protocolfurniture.com/privacy-policy/">Privacy Policy</a></li>
                <li><a href="https://apalmanac.com/business/photo-licensing-101-the-basics-explained-176320">Image Licensin</a></li>
                <li><a href="https://www.behance.net/gallery/203184857/Raven-Furniture-Brand-Guidelines-Brand-Style-Guide?tracking_source=search_projects|furniture+brand+guide&l=1">Style Guide</a></li>
            </ul>
        </div>

        <div class="lower-footer-items">
            <h3>Shop Category</h3>
            <ul>
                <li><a href="product.php?category=Sofas">Sofa</a></li>
                <li><a href="product.php?category=Beds">Bed</a></li>
                <li><a href="product.php?category=Chair">Chair</a></li>
                <li><a href="product.php?category=Dining">Dining</a></li>
            </ul>
        </div>

        <div class="lower-footer-items">
            <h3>Partners</h3>
            <ul>
                <li><a href="https://www.behance.net/gallery/203184857/Raven-Furniture-Brand-Guidelines-Brand-Style-Guide?tracking_source=search_projects|furniture+brand+guide&l=1">Reaven Group</a></li>
                <li><a href="https://parasdefence.com/">Paras Group</a></li>
                <li><a href="https://www.asianpaints.com/">Assian Paints</a></li>
            </ul>
        </div>
        </div>
    </footer>

    <script src="script.js">
    document.addEventListener("DOMContentLoaded", () => {
        const menuBar = document.querySelector(".menu-bar");
        const navbar = document.querySelector(".navbar");
    
        menuBar.addEventListener("click", () => {
        // Toggle the visibility of the navbar
        navbar.style.display = navbar.style.display === "flex" ? "none" : "flex";
        });

    });
    
    
    </script>
      

</body>
</html>
