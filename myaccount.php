<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: useraccount.php");
    exit;
}

// Include database connection
include 'db_connect.php';

// Fetch logged-in user's data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result); // Fetch user details
} else {
    echo "User not found.";
    exit;
}


// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['phone']));

    // Check for duplicate email
    $emailCheckQuery = "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);
    if (mysqli_num_rows($emailCheckResult) > 0) {
        $errorMessage = "This email is already in use by another account.";
    } else {
        // Update query
        $updateQuery = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$user_id'";

        if (mysqli_query($conn, $updateQuery)) {
            $successMessage = "Profile updated successfully!";
            // Refresh the user data
            $result = mysqli_query($conn, $query);
            $user = mysqli_fetch_assoc($result);
        } else {
            $errorMessage = "Error updating profile: " . mysqli_error($conn);
        }
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

    <div class="user-account">
        <h2>My Account</h2>

        <!-- Display success or error messages -->
        <?php if (!empty($successMessage)): ?>
            <div class="success-message"> <?php echo $successMessage; ?> </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="error-message"> <?php echo $errorMessage; ?> </div>
        <?php endif; ?>

        <form action="myaccount.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <button type="submit" name="update">Update Profile</button>
        </form>

        <!-- View Order History Button -->
        <a href="orderhistory.php" class="view-orders">View Order History</a>
    </div>
    
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
            <div class="footer-contact">
                <p><strong>Email:</strong> info@watchstore.com</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Address:</strong> Mirpurkhas, Sindh</p>
            </div>
            <p class="copyright">
                &copy; 2024 Watch Store. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
