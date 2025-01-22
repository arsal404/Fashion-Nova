<?php
session_start();
include 'db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: useraccount.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = "SELECT name, email, phone FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['address']));
    $city = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['city']));
    $zip_code = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['zip_code']));
    $country = 'Pakistan';
    
    $payment_method = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['payment_method']));

    // Calculate total amount from cart
    $cart_total = 0;
    foreach ($_SESSION['cart'] as $product_id => $details) {
        $product_query = "SELECT price FROM products WHERE id = '$product_id'";
        $product_result = mysqli_query($conn, $product_query);
        $product = mysqli_fetch_assoc($product_result);
        
        // Ensure that the price is numeric and quantity is a number
        if (isset($product['price']) && is_numeric($product['price']) && isset($details['quantity']) && is_numeric($details['quantity'])) {
            $cart_total += $product['price'] * $details['quantity'];
        } else {
            // Handle invalid price or quantity
            $cart_total += 0;
        }
    }

    // Insert order into orders table
    $order_query = "INSERT INTO orders (user_id, total_amount, payment_method, address, city, zip_code, country, created_at) 
                    VALUES ('$user_id', '$cart_total', '$payment_method', '$address', '$city', '$zip_code', '$country', NOW())";
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);  // Get the order ID

        // Insert order items into order_items table
        foreach ($_SESSION['cart'] as $product_id => $details) {
            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                           SELECT '$order_id', '$product_id', '{$details['quantity']}', price 
                           FROM products WHERE id = '$product_id'";
            mysqli_query($conn, $item_query);
        }

        // Clear the cart after successful checkout
        unset($_SESSION['cart']);

        // Redirect to order history page with success message
        header("Location: orderhistory.php?success=order_placed");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
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

    <h2>Checkout</h2>    
    <form action="checkout.php" method="POST" id="checkout">
        <div class="checkout-form">
            <h3>User Details</h3>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

            <h3>Shipping Address</h3>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" required>

            <label for="country">Country: (Pakistan)</label>
            <input type="text" id="country" name="country" value="Pakistan" readonly>

            <h3>Payment Method</h3>
            <select name="payment_method" required>
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>

            <h3>Order Summary</h3>
            <ul>
                <?php
                $cart_total = 0; // Initialize cart total
                foreach ($_SESSION['cart'] as $product_id => $details) {
                    $product_query = "SELECT name, price FROM products WHERE id = '$product_id'";
                    $product_result = mysqli_query($conn, $product_query);
                    $product = mysqli_fetch_assoc($product_result);
                    
                    // Ensure that price and quantity are valid numbers
                    if (isset($product['price']) && is_numeric($product['price']) && isset($details['quantity']) && is_numeric($details['quantity'])) {
                        $product_total = $product['price'] * $details['quantity'];
                        $cart_total += $product_total;
                    } else {
                        $product_total = 0;
                    }
                ?>
                    <li>Product Name: <?php echo htmlspecialchars($product['name']); ?> (Quantity: <?php echo $details['quantity']; ?>) - Rs. <?php echo number_format($product_total, 2); ?></li>
                <?php } ?>
            </ul>

            <p><strong>Total Amount:</strong> Rs. <?php echo number_format($cart_total, 2); ?></p>

            <button type="submit">Place Order</button>
        </div>
    </form>

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