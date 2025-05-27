<?php
session_start();
$conn = mysqli_connect('127.0.0.1', 'root', '', 'furn') or die("Database Connection Error!");

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Get user email
$user_query = "SELECT email FROM register WHERE name = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$email = $user['email']; 

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $img = $_POST['img'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    

    // Check if the product is already in the cart
    $check_cart = "SELECT * FROM cart WHERE email = '$email' AND model = '$model'";
    $cart_result = mysqli_query($conn, $check_cart);

    if (mysqli_num_rows($cart_result) > 0) {
        // If product exists, increase quantity
        $update_cart = "UPDATE cart SET quantity = quantity + 1 WHERE email = '$email' AND model = '$model'";
        mysqli_query($conn, $update_cart);
    } else {
        // Otherwise, insert as a new item
        $insert_cart = "INSERT INTO cart (email, img, model, price, quantity) 
                        VALUES ('$email', '$img', '$model', '$price', 1)";
        mysqli_query($conn, $insert_cart);
    }

}

// Fetch products
$category = isset($_GET['category']) ? $_GET['category'] : 'All';
$sql = "SELECT * FROM details";
if ($category != 'All') {
    $sql .= " WHERE category = '$category'";
}
$result = $conn->query($sql);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

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
                            <li><a href="home.php">Home</a></li>
                            <li><a href="product.php">Product</a></li>
                            <li><a href="About.php">About</a></li>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="Contact.php">Contact</a></li>
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
                    <p><a href="home.php">Home </a>> Product</p>
                </div>
            </div>  

        </header>

        <product>
            <div class="product-heading">
                <h1>POPULAR PRODUCTS</h1>
                <h4>Explore a wide range of modern and classic furniture styles. From cozy sofas to elegant dining sets, our
                    collection is designed to suit every taste and space. Transform your home with quality craftsmanship and
                    timeless designs</h4>
            </div>

            <div class="product-category">
        <ul>
            <li><a href="product.php?category=All">All</a></li>
            <li><a href="product.php?category=Sofas">Sofas</a></li>
            <li><a href="product.php?category=Tables">Tables</a></li>
            <li><a href="product.php?category=Chairs">Chairs</a></li>
            <li><a href="product.php?category=Beds">Beds</a></li>
            <li><a href="product.php?category=Dining">Dining</a></li>
        </ul>
    </div>
   
    <div class="product-grid">
    <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product-item">
            <a href="details.php?model=<?php echo $row['model']; ?>"><img src="<?php echo $row['img']; ?>" alt=""></a>
               <h3><?php echo $row['model']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p>Price: ₹<?php echo $row['price']; ?></p>
                <form method="POST">
                    <input type="hidden" name="model" value="<?php echo $row['model']; ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    <input type="hidden" name="des" value="<?php echo $row['description']; ?>">
                    <input type="hidden" name="img" value="<?php echo $row['img']; ?>">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
            </section>
        </product>
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