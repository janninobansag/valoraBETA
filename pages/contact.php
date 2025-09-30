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
    <title>Valora | Contact</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'navbar-user.php'; ?>
    <div class="container">
        <h2>Contact Us</h2>
        <p>Email: support@valora.com<br>Phone: 0912-345-6789</p>
    </div>
</body>
</html>