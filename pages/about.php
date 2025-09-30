<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user'])) {
    header("Location: login.php?error=unauthorized");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Valora | About Us</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'navbar-user.php'; ?>
    <div class="container">
        <h2>About Us</h2>
        <p>Valora is your go-to shop for stylish and affordable t-shirts. Our mission is to bring comfort and style to everyone!</p>
    </div>
</body>
</html>