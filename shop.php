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

// Initialize the cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_to_cart') {
    $product_id = intval($_POST['product_id']);
    $quantity = 1; // Default quantity

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Increment the quantity
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Add product to the cart
        $_SESSION['cart'][$product_id] = ['quantity' => $quantity];
    }

    // Return a JSON response
    echo json_encode(['status' => 'success', 'message' => 'Product added to cart!']);
    exit;
}



// Function to fetch 4 products by category
function getLimitedProductsByCategory($categoryId, $conn) {
    $sql = "SELECT id, picture_main, name, price FROM products WHERE subcategory_id = ? LIMIT 4";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    return $products;
}

// Category-to-ID mapping
$categoryIds = [
    'Rolex' => 14, 
    'Dior' => 15,
    'Tomi' => 16,
    'Gucci' => 17,
    'Sveston Prime' => 18,
    'Sveston' => 19,
    'Sveston Watch' => 20,
];

// Get 4 products for each category
$productCards = [];
foreach ($categoryIds as $category => $id) {
    $products = getLimitedProductsByCategory($id, $conn);
    $productCards = array_merge($productCards, $products);
}

// Shuffle products for random mixture
shuffle($productCards);


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
                            <a href="#">Analog</a>
                            <div class="submenu-content">
                                <a href="a_rolex.php">Rolex</a>
                                <a href="a_dior.php">Dior</a>
                            </div>
                        </div>
                        <div class="dropdown-submenu">
                            <a href="#">Digital</a>
                            <div class="submenu-content">
                                <a href="d_tomi.php">Tomi</a>
                                <a href="d_gucci.php">Gucci</a>
                            </div>
                        </div>
                        <div class="dropdown-submenu">
                            <a href="#">Smart</a>
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
	
	<!-- Chatbot Toggle Button -->
    <button class="chat-toggle-btn" onclick="toggleChat()">Chat with us</button>

    <!-- Chatbot Container -->
    <div class="chat-container" id="chat-container">
        <div class="chat-header">
            Fashion Nova Chatbot
            <p>Ask me</p>
        </div>
        <div class="chat-box" id="chat-box">
            <!-- Chat messages will appear here -->
        </div>

        <div class="user-input-section">
            <input id="user-input" class="user-input" type="text" placeholder="Type a question, e.g., 'Show me analog watches'">
            <button class="send-btn" onclick="sendMessage()">Send</button>
        </div>
    </div>
	
	
	<div id="cart-message" style="display: none;"></div>
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

    <!-- Shop Page Content -->
	<section class="product-grid">
		<div class="container">
			<h2 class="section-title">Our Collection</h2>
			<div class="grid">
				<?php
				foreach ($productCards as $product) {
					echo "
					<div class='product-card' data-product-id='" . $product['id'] . "'>
						<img src='../admin/uploads/" . $product['picture_main'] . "' alt='" . $product['name'] . "'>
						<h3 class='product-name'>" . $product['name'] . "</h3>
						<p class='product-price'>Rs. " . number_format($product['price'], 2) . "</p>
						<div class='product-actions'>
							<button class='btn add-to-cart' data-product-id='" . $product['id'] . "'>Add to Cart</button>
							<a href='pdetails.php?id=" . $product['id'] . "' class='btn view-details'>View Details</a>
						</div>
					</div>";
				}
				?>
			</div>
		</div>
	</section>

    <!-- Footer -->
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
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const addToCartButtons = document.querySelectorAll('.add-to-cart');

			addToCartButtons.forEach(button => {
				button.addEventListener('click', function (event) {
					event.preventDefault(); // Prevent default action

					const productId = this.getAttribute('data-product-id');

					// Send AJAX request
					fetch('shop.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'add_to_cart',
							product_id: productId,
						}),
					})
					.then(response => response.json())
					.then(data => {
						if (data.status === 'success') {
							const cartMessage = document.getElementById('cart-message');
							cartMessage.textContent = data.message;
							cartMessage.style.display = 'block';
							cartMessage.style.backgroundColor = '#d4edda';
							cartMessage.style.color = '#155724';
							cartMessage.style.padding = '10px';
							cartMessage.style.marginTop = '10px';
							cartMessage.style.borderRadius = '5px';

							// Hide the message after 3 seconds
							setTimeout(() => {
								cartMessage.style.display = 'none';
							}, 1000);
						}
					})
					.catch(error => {
						console.error('Error:', error);
					});
				});
			});
		});



        // Toggle chat box visibility
        function toggleChat() {
            const chatContainer = document.getElementById("chat-container");
            // Show or hide chat box on button click
            if (chatContainer.style.display === "none" || chatContainer.style.display === "") {
                chatContainer.style.display = "flex";
            } else {
                chatContainer.style.display = "none";
            }
        }

        function sendMessage() {
            const userMessage = document.getElementById("user-input").value;

            if (userMessage.trim() === "") return;

            const chatBox = document.getElementById("chat-box");

            // Display user's message
            const userMessageDiv = document.createElement("div");
            userMessageDiv.classList.add("message", "user-message");
            userMessageDiv.textContent = userMessage;
            chatBox.appendChild(userMessageDiv);

            // Send message to Flask API
            fetch("http://127.0.0.1:5000/ask", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ question: userMessage }),
            })
            .then((response) => {
                if (!response.ok) {
                    console.error("API error:", response.statusText);
                    throw new Error("API error");
                }
                return response.json();
            })
            .then((data) => {
                // Display bot's response
                const botReplyDiv = document.createElement("div");
                botReplyDiv.classList.add("message", "bot-message");
                botReplyDiv.textContent = data.reply || "I couldn't understand that. Could you rephrase?";
                chatBox.appendChild(botReplyDiv);

                // Scroll to bottom
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch((error) => {
                console.error("Error:", error);
                const errorDiv = document.createElement("div");
                errorDiv.classList.add("message", "bot-message");
                errorDiv.textContent = "There was an error processing your request. Please try again later.";
                chatBox.appendChild(errorDiv);
            });

            // Clear input field
            document.getElementById("user-input").value = "";
        }
    </script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>