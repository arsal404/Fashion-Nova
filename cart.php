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

// Handle removing an item from the cart
if (isset($_POST['remove_product_id'])) {
    $product_id_to_remove = $_POST['remove_product_id'];
    unset($_SESSION['cart'][$product_id_to_remove]);
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
	
    <?php
    // Get cart items from session
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        echo "<h2>Your Cart</h2>";
        echo "<table border='1' cellpadding='10'>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

        $total_cart_value = 0; // Variable to track the total cart value

        foreach ($_SESSION['cart'] as $product_id => $details) {
            // Fetch product details from the database
            $query = "SELECT name, price FROM products WHERE id = $product_id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            $product_name = $row['name'];
            $product_price = $row['price'];
            $product_quantity = $details['quantity'];
            $total_price = $product_price * $product_quantity;

            // Add to the total cart value
            $total_cart_value += $total_price;

            echo "<tr>
                    <td>{$product_name}</td>
                    <td>Rs. {$product_price}</td>
                    <td>{$product_quantity}</td>
                    <td>Rs. {$total_price}</td>
                    <td>
                        <form method='POST' action='cart.php' style='display:inline;'>
                            <input type='hidden' name='remove_product_id' value='{$product_id}'>
                            <button type='submit' class='remove-btn'>Remove</button>
                        </form>
                    </td>
                </tr>";
        }

        echo "</tbody>
            </table>";

        // Display the total cart value
        echo "<p><strong>Subtotal: Rs. {$total_cart_value}</strong></p>";

        // Add the "Proceed to Checkout" button
        echo "<form method='GET' action='checkout.php' style='text-align: center; margin-top: 20px;'>
                <button type='submit' class='checkout-btn'>Proceed to Checkout</button>
            </form>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>

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
                    <p><strong>Address:</strong> 123 Watch Lane, New York, NY</p>
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
