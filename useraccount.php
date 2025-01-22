<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Nova</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
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
    <?php if (isset($_GET['success'])): ?>
        <p class="success-message">Registration successful! Please login.</p>
    <?php elseif (isset($_GET['error'])): ?>
        <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <!-- User Account Page Section -->
    <section class="user-account">
        <div class="container">
            <h2>User Account</h2>

            <div class="account-content">
                <!-- Registration Form: Initially Hidden -->
                <div class="form-container register-form hidden">
                    <h3>Create an Account</h3>
                    <form id="register-form" method="POST" action="register.php">
                        <div class="form-group">
                            <label for="register-name">Full Name</label>
                            <input type="text" id="register-name" name="register-name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="register-email">Email Address</label>
                            <input type="email" id="register-email" name="register-email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="register-phone">Phone Number</label>
                            <input type="tel" id="register-phone" name="register-phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="form-group">
                            <label for="register-password">Password</label>
                            <input type="password" id="register-password" name="register-password" placeholder="Enter a password" required>
                        </div>
                        <button type="submit" class="btn">Sign Up</button>
                    </form>
                    <div class="existing-user">
                        <p>Already have an account? <span id="switch-to-login" class="link">Login here</span></p>
                    </div>
                </div>

                <!-- Login Form: Initially Visible -->
                <div class="form-container login-form">
                    <h3>Login to Your Account</h3>
                    <form id="login-form" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="login-email">Email Address</label>
                            <input type="email" id="login-email" name="login-email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" id="login-password" name="login-password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn">Login</button>
                    </form>
                    <div class="existing-user">
                        <p>Don't have an account? <span id="switch-to-register" class="link">Register here</span></p>
                    </div>
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

    <script>
        // Toggle between Login and Register forms
        document.getElementById('switch-to-register').addEventListener('click', function () {
            document.querySelector('.register-form').classList.toggle('hidden');
            document.querySelector('.login-form').classList.toggle('hidden');
        });

        document.getElementById('switch-to-login').addEventListener('click', function () {
            document.querySelector('.register-form').classList.toggle('hidden');
            document.querySelector('.login-form').classList.toggle('hidden');
        });
    </script>
</body>
</html>