<?php
session_start();
ini_set('memory_limit', '512M'); // Increase memory limit

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'fashionnova';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products only for the Rolex subcategory
$sql = "SELECT p.id, p.picture_main, p.name, p.price FROM products p
    INNER JOIN subcategories s ON p.subcategory_id = s.id
    INNER JOIN categories c ON s.category_id = c.id
    WHERE s.subcategory_name = 'Sveston Prime'
    LIMIT 20";

$result = $conn->query($sql);

// Handle add to cart action without redirect
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']); // Ensure it's an integer
    $quantity = 1; // Default quantity

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Increment the quantity
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Add product to the cart
        $_SESSION['cart'][$product_id] = ['quantity' => $quantity];
    }

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
    <link rel="stylesheet" href="message.css">
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
            }, 3000); // Hide message after 3 seconds
        </script>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <section class="product-grid">
        <div class="container">
            <h2 class="section-title">Sveston Primo Watches</h2>
            <div class="grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <div class='product-card' data-product-id='" . $row['id'] . "'>
                            <img src='../admin/uploads/" . $row['picture_main'] . "' alt='" . $row['name'] . "'>
                            <h3 class='product-name'>" . $row['name'] . "</h3>
                            <p class='product-price'>Rs. " . $row['price'] . "</p>
                            <div class='product-actions'>
                                <form method='POST' action='s_sveston1.php'>
                                    <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                    <button class='btn add-to-cart'>Add to Cart</button>
                                </form>
                                <a href='pdetails.php?id=" . $row['id'] . "' class='btn view-details'>View Details</a>
                            </div>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>No products found for Sveston Primo.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
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
            <div class="footer-social">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
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
