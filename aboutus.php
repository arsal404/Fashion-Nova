<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Nova</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
	<header>
		<div class="logo">
			<a href="#">Fashion <span>Nova</span></a>
		</div>
		<div class="menu-toggle" onclick="toggleMenu()">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="shop.php">Shop</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li class="dropdown">
					<a href="#">Categories</a>
					<div class="dropdown-content">
						<div class="dropdown-submenu">
							<a href="#" class="ctg">Analog</a>
							<div class="submenu-content">
								<a href="a_rolex.php">Rolex</a>
								<a href="a_dior.php">Dior</a>
							</div>
						</div>
						<div class="dropdown-submenu">
							<a href="#" class="ctg">Digital</a>
							<div class="submenu-content">
								<a href="d_tomi.php">Tomi</a>
								<a href="d_gucci.php">Gucci</a>
							</div>
						</div>
						<div class="dropdown-submenu">
							<a href="#" class="ctg">Smart</a>
							<div class="submenu-content">
								<a href="s_sveston1.php">Sveston Primo</a>
								<a href="s_sveston2.php">Sveston </a>
								<a href="s_sveston3.php">Sveston Watch</a>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</nav>
		<div class="icons">
			<a href="cart.php" class="cart-icon"><img src="cart-icon.png" alt="Cart"></a>
			<?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="logout">Logout</a>
            <a href="myaccount.php" class="my-account">My Account</a>	
			<?php else: ?>
			<a href="useraccount.php" class="user-icon"><img src="user-icon.png" alt="User"></a>
			<?php endif; ?>
		</div>
	</header>
	
	<!-- About Us -->
	<main>
	  <!-- Hero Section -->
	  <section class="hero-about">
		<div class="hero-text">
		  <h1>About Us</h1>
		  <p>Crafting Timeless Watches for Every Moment</p>
		</div>
	  </section>

	  <!-- Brand Story Section -->
	  <section class="brand-story">
		<div class="container">
		  <h2>Our Story</h2>
		  <p>
			Established with a passion for precision and elegance, we have been creating
			timeless pieces for watch enthusiasts worldwide. Our journey began with a
			mission to combine craftsmanship, innovation, and style in every design.
		  </p>
		  <img src="images/aboutus/1.jpg" alt="Our Story">
		</div>
	  </section>

	  <!-- Why Choose Us Section -->
	  <section class="why-choose-us">
		<div class="container">
		  <h2>Why Shop with Us?</h2>
		  <div class="features">
			<div class="feature">
			  <i class="fas fa-check-circle"></i>
			  <h3>High-Quality Products</h3>
			  <p>We provide only the best watches crafted with care and precision.</p>
			</div>
			<div class="feature">
			  <i class="fas fa-shipping-fast"></i>
			  <h3>Fast & Secure Delivery</h3>
			  <p>Your orders are delivered quickly and securely to your doorstep.</p>
			</div>
			<div class="feature">
			  <i class="fas fa-star"></i>
			  <h3>Trusted by Thousands</h3>
			  <p>Join our community of satisfied customers worldwide.</p>
			</div>
		  </div>
		</div>
	  </section>
	
    <!-- Footer -->
	<footer class="footer">
	  <div class="container">
		<!-- Footer Top Section -->
		<div class="footer-top">
		  <div class="footer-brand">
			<h2>FASHION <span>NOVA</span></h2>
			<p>Your one-stop shop for premium watches</p>
		  </div>
		  <div class="footer-links">
			<a href="#">Privacy Policy</a>
			<a href="#">Terms of Service</a>
			<a href="#">Contact Us</a>
		  </div>
		</div>

		<!-- Footer Social Section -->
		<div class="footer-social">
		  <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
		  <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
		  <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
		  <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
		</div>

		<!-- Footer Bottom Section -->
		<div class="footer-bottom">
		  <div class="footer-contact">
			<p><strong>Email:</strong> info@watchstore.com</p>
			<p><strong>Phone:</strong> +123 456 7890</p>
			<p><strong>Address:</strong> Mirpurkhas, Sindh</p>
		  </div>
		  <p class="copyright">
			&copy; 2024 Watch Store. All rights reserved.
		  </p>
		</div>
	  </div>
	</footer>

<script src="script.js"></script>
</body>
</html>
