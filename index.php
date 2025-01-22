<?php
session_start();
include 'db_connect.php';
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

    <!-- HeroSection -->
    <section class="hero">
        <div class="slider">
            <div class="slide active">
                <div class="hero-content">
                    <h1>Discover Timeless Elegance</h1>
                    <p>Shop the finest collection of watches now.</p>
                    <a href="shop.php" class="cta-button">Shop Now</a>
                </div>
            </div>
            <div class="slide">
                <div class="hero-content">
                    <h1>Luxury Redefined</h1>
                    <p>Explore exclusive designs for every occasion.</p>
                    <a href="shop.php" class="cta-button">Shop Now</a>
                </div>
            </div>
            <div class="slide">
                <div class="hero-content">
                    <h1>Precision & Style</h1>
                    <p>Find your perfect timepiece today.</p>
                    <a href="shop.php" class="cta-button">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="controls">
            <span class="prev">&lt;</span>
            <span class="next">&gt;</span>
        </div>
	</section>

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


<!-- Featured Products Section -->
    <section id="featured-products">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="product-grid">
                <?php
                $sql = "SELECT p.* FROM products p 
                        JOIN featured_products fp ON p.id = fp.product_id";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card'>";
                    echo "<img src='../admin/uploads/" . $row['picture_main'] . "' alt='" . $row['name'] . "'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p> RS." . $row['price'] . "</p>";
                    echo "<a href='pdetails.php?id=" . $row['id'] . "' class='btn'>View Details</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </section>
	
    <!-- newsletterSection -->
	<section id="newsletter">
		<div class="container">
			<h2>Subscribe to Our Newsletter</h2>
			<p class="newsletter-text">Stay updated with the latest trends and offers.</p>
				<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subscribe_email'])) {
					$email = $_POST['email'];

					// Insert email into newsletter_subscribers table
					$sql = "INSERT INTO newsletter_subscribers (email) VALUES ('$email')";
					if ($conn->query($sql) === TRUE) {
						echo "Thank you for subscribing!";
					} else {
						echo "Error: " . $conn->error;
					}
				}
				?>
			<form method="POST">
				<input type="email" name="email" placeholder="Enter your email" required>
				<button type="submit" name="subscribe_email">Subscribe</button>
			</form>
		</div>
	</section>

    <!-- New Arrivals Section -->
    <section id="new-arrivals">
        <div class="container">
            <h2 class="section-title">New Arrivals</h2>
            <div class="product-grid">
                <?php
                $sql = "SELECT p.* FROM products p 
                        JOIN new_arrivals na ON p.id = na.product_id";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card'>";
                    echo "<img src='../admin/uploads/" . $row['picture_main'] . "' alt='" . $row['name'] . "'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>RS." . $row['price'] . "</p>";
                    echo "<a href='pdetails.php?id=" . $row['id'] . "' class='btn'>View Details</a>";
                    echo "</div>";
                }
                ?>
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

    <!-- JavaScript Code -->
    <script>
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

<script src="script.js"></script>
</body>
</html>
