<?php
session_start();
include 'db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch order history for the logged-in user
$order_query = "SELECT orders.id AS order_id, orders.total_amount, orders.payment_method, 
                        orders.address, orders.city, orders.created_at, 
                        users.name
                 FROM orders
                 JOIN users ON orders.user_id = users.id
                 WHERE orders.user_id = '$user_id'
                 ORDER BY orders.created_at DESC";

$order_result = mysqli_query($conn, $order_query);
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
	<div class="orderhistory">
		<h2>Order History</h2>    
		<table>
			<thead>
				<tr>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Total Amount</th>
					<th>Payment Method</th>
					<th>Address</th>
					<th>City</th>
					<th>Order Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($order = mysqli_fetch_assoc($order_result)) {
					// Fetch order items for the current order
					$order_items_query = "SELECT product_id, quantity FROM order_items WHERE order_id = '{$order['order_id']}'";
					$order_items_result = mysqli_query($conn, $order_items_query);

					while ($order_item = mysqli_fetch_assoc($order_items_result)) {
						// Fetch product details for each item
						$product_query = "SELECT name FROM products WHERE id = '{$order_item['product_id']}'";
						$product_result = mysqli_query($conn, $product_query);
						$product = mysqli_fetch_assoc($product_result);
						?>
						<tr>
							<td><?php echo htmlspecialchars($product['name']); ?></td>
							<td><?php echo $order_item['quantity']; ?></td>
							<td><?php echo number_format($order['total_amount'], 2); ?></td>
							<td><?php echo htmlspecialchars($order['payment_method']); ?></td>
							<td><?php echo htmlspecialchars($order['address']); ?></td>
							<td><?php echo htmlspecialchars($order['city']); ?></td>
							<td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])); ?></td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
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