<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=login_required');
    exit;
}

// Add to cart logic
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'] ?? 1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

header('Location: shop.php?success=added_to_cart');
exit;
?>