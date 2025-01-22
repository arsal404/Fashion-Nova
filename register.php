<?php
require 'db_connect.php'; // Ensure DB connection


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['register-name'];
    $email = $_POST['register-email'];
    $phone = $_POST['register-phone'];
    $password = password_hash($_POST['register-password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $password);

    if ($stmt->execute()) {
        header("Location: useraccount.php?success=registration");
    } else {
        header("Location: useraccount.php?error=registration_failed");
    }
}
?>