<?php

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user'])) {
    header("Location: login.php?error=unauthorized");
    exit();
}

// Initialize cart in session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle remove from cart
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
    header("Location: shopping_cart.php");
    exit();
}

// Handle clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: shopping_cart.php");
    exit();
}

$user = $_SESSION['user'];
$cart = $_SESSION['cart'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Valora | Shopping Cart</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: black; color: #e7e7e7; }
        .cart-container {
            max-width: 700px;
            margin: 3rem auto;
            background: #181818;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(127,66,167,0.10);
            padding: 2rem 2.5rem;
        }
        .cart-title {
            color: #7f42a7;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .cart-table {
            background: #181818;
            border-radius: 12px;
            overflow: hidden;
        }
        .cart-table th, .cart-table td {
            vertical-align: middle;
            color: #e7e7e7;
            background: #181818;
        }
        .cart-table th {
            color: #a7a7a7;
            font-weight: 600;
        }
        .cart-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: #222;
            border: 2px solid #7f42a7;
        }
        .remove-btn {
            background: none;
            border: none;
            color: #ff4d6d;
            font-size: 1.3rem;
            cursor: pointer;
        }
        .cart-total-row td {
            font-weight: bold;
            color: #a7a7a7;
            border-top: 2px solid #7f42a7;
            background: #181818;
        }
        .empty-cart {
            color: #a7a7a7;
            text-align: center;
            font-size: 1.2rem;
            margin: 2rem 0;
        }
        .cart-actions {
            text-align: right;
            margin-top: 1.5rem;
        }
        .btn-clear {
            background: #ff4d6d;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            margin-right: 1rem;
            transition: background 0.2s;
        }
        .btn-clear:hover {
            background: #a7a7a7;
            color: #222;
        }
        .btn-checkout {
            background: linear-gradient(90deg, #7f42a7 0%, #6600c5 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-checkout:hover {
            background: #a7a7a7;
            color: #222;
        }
    </style>
</head>
<body>
    <?php include 'navbar-user.php'; ?>
    <div class="container cart-container">
        <div class="cart-title"><i class="fas fa-shopping-cart"></i> Your Shopping Cart</div>
        <?php if (empty($cart)): ?>
            <div class="empty-cart">Your cart is empty. <a href="shop.php" style="color:#7f42a7;">Go shopping!</a></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table cart-table align-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; foreach ($cart as $i => $item): 
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($item['img']); ?>" class="cart-img" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo $item['qty']; ?></td>
                            <td>₱<?php echo $item['price']; ?></td>
                            <td>₱<?php echo $subtotal; ?></td>
                            <td>
                                <a href="?remove=<?php echo $i; ?>" class="remove-btn" title="Remove">&times;</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="cart-total-row">
                            <td colspan="4" class="text-end">Total:</td>
                            <td colspan="2">₱<?php echo $total; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart-actions">
                <a href="?clear=1" class="btn-clear">Clear Cart</a>
                <a href="#" class="btn-checkout">Checkout</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</body>
</html>