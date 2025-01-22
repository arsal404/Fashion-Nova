<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'fashionnova';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);  
        $pic = $row['picture_main'];  
        $pic1 = $row['picture1'];  
        $pic2 = $row['picture2'];  
        $pic3 = $row['picture3'];
        $nm = $row['name'];  
        $des = $row['description'];  
        $price = $row['price'];  
        $qty = $row['quantity'];
    } else {
        echo "Product not found.";
        exit;
    }
}

// Handle add to cart action without redirect
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart session
    $_SESSION['cart'][$product_id] = ['quantity' => $quantity];

    // Set a message to display on the page
    $_SESSION['cart_message'] = "Product added to cart!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Nova</title>
    <link rel="stylesheet" href="style.css">
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
								<a href="s_sveston2.php">Sveston</a>
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

    <!-- Show Cart Message -->
    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="cart-message">
            <?php echo $_SESSION['cart_message']; ?>
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.cart-message').style.display = 'none';
            }, 1000); // Hide message after 3 seconds
        </script>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <section class="product-details">
        <div class="container">
            <div class="product-container">
                <div class="image-gallery">
					<img id="main-img" src="../admin/uploads/<?php echo $pic; ?>" class="large-img">
					<div class="small-images">
						<img src="../admin/uploads/<?php echo $pic; ?>" onclick="changeImage('../admin/uploads/<?php echo $pic; ?>')">
						<img src="../admin/uploads/<?php echo $pic1; ?>" onclick="changeImage('../admin/uploads/<?php echo $pic1; ?>')">
						<img src="../admin/uploads/<?php echo $pic2; ?>" onclick="changeImage('../admin/uploads/<?php echo $pic2; ?>')">
						<img src="../admin/uploads/<?php echo $pic3; ?>" onclick="changeImage('../admin/uploads/<?php echo $pic3; ?>')">
					</div>
                </div>
                <div class="product-details">
                    <h2><?php echo $nm; ?></h2>
                    <p><?php echo $des; ?></p>
                    <p><strong>Price: Rs. <?php echo $price; ?></strong></p>
                    <form method="POST" action="pdetails.php?id=<?php echo $product_id; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $qty; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button class="add-to-cart" type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
	
	<script>
    function changeImage(imageUrl) {
        document.getElementById('main-img').src = imageUrl;
    }
	</script>

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
