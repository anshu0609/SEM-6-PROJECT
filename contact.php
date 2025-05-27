<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$conn=mysqli_connect('127.0.0.1','root','','furn') or die("Database Connection Error!");
		if(isset($_POST['frmsubmit']))
		{

			$str="insert into contact values('".$_POST['message']."','".$_POST['name']."','".$_POST['email']."','".$_POST['subject']."')";
			mysqli_query($conn,$str);
			echo "<script>alert('Message sent successfully!')</script>";
		}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
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
                s.addEventListener('load', function () {
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
            <h1>CONTACT US</h1>
            <p><a href="">Home </a>> Contact</p>
        </div>
    </div>

</header>
<div class="frame">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7539.56673120513!2d72.91129605!3d19.11715735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c7e5489f8b2d%3A0xd9e71bac408c562b!2sHiranandani%20Gardens%2C%20Powai%2C%20Mumbai%2C%20Maharashtra%20400076!5e0!3m2!1sen!2sin!4v1684736956610!5m2!1sen!2sin" width="900" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<div class="container contact-section">
<form  method="POST">
    <div class="mb-3">
        <textarea class="form-control" name="message" rows="5" placeholder="Enter Message" required></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
        </div>
        <div class="col-md-6 mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
    </div>
    <div class="mb-3">
        <input type="text" class="form-control" name="subject" placeholder="Enter Subject" required>
    </div>
    <button type="submit" name="frmsubmit" class="btn send-btn">SEND</button>
</form> 
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

    });</script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>