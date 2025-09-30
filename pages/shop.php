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

// Handle add to cart POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $name = $_POST['name'];
    $price = (int)$_POST['price'];
    $img = $_POST['img'];

    // Check if item already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name) {
            $item['qty'] += 1;
            $found = true;
            break;
        }
    }
    unset($item);
    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => $price,
            'img' => $img,
            'qty' => 1
        ];
    }
    // Redirect to avoid form resubmission
    header("Location: shop.php?added=" . urlencode($name));
    exit();
}

// Product data
$products = [
    [
        "name" => "Classic White Tee",
        "price" => 249,
        "oldPrice" => 499,
        "img" => "https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=400&q=80"
    ],
    [
        "name" => "Black Urban Shirt",
        "price" => 299,
        "oldPrice" => 599,
        "img" => "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=400&q=80"
    ],
    [
        "name" => "Graphic Tee",
        "price" => 349,
        "oldPrice" => 699,
        "img" => "https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=400&q=80"
    ],
    [
        "name" => "Minimalist Tee",
        "price" => 279,
        "oldPrice" => 549,
        "img" => "https://images.unsplash.com/photo-1469398715555-76331a6c7fa0?auto=format&fit=crop&w=400&q=80"
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Valora | Shop</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: black;
            color: #e7e7e7;
        }
        .shop-banner {
            background: linear-gradient(90deg, #7f42a7 0%, #6600c5 100%);
            color: #fff;
            border-radius: 18px;
            padding: 2rem 2.5rem;
            margin: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 24px rgba(127,66,167,0.15);
            letter-spacing: 1px;
        }
        .search-box {
            display: flex;
            justify-content: center;
            margin: 1.5rem 0 0.5rem 0;
        }
        .search-input {
            width: 320px;
            padding: 0.7rem 1.2rem;
            border-radius: 50px 0 0 50px;
            border: 2px solid #7f42a7;
            outline: none;
            font-size: 1rem;
            background: #181818;
            color: #e7e7e7;
        }
        .search-btn {
            padding: 0.7rem 1.5rem;
            border-radius: 0 50px 50px 0;
            border: 2px solid #7f42a7;
            background: linear-gradient(90deg, #7f42a7 0%, #6600c5 100%);
            color: ##181818;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .search-btn:hover {
            background: #a7a7a7;
            color: #222;
        }
        .products-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            margin-top: 2rem;
        }
        .product-card {
            background: #181818;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(127,66,167,0.10);
            padding: 1.5rem;
            width: 260px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1.5px solid #7f42a7;
        }
        .product-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 8px 32px rgba(127,66,167,0.25);
            border-color: #a7a7a7;
        }
        .product-img {
            width: 100%;
            height: 180px;
            object-fit: contain;
            margin-bottom: 1rem;
            border-radius: 8px;
            background: #222;
            border: 2px solid #7f42a7;
        }
        .product-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #a7a7a7;
            letter-spacing: 0.5px;
        }
        .product-price {
            color: #7f42a7;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .btn-cart {
            background: linear-gradient(90deg, #7f42a7 0%, #6600c5 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px rgba(127,66,167,0.10);
        }
        .btn-cart:hover {
            background: #a7a7a7;
            color: #222;
        }
        .cart-notification {
            position: fixed;
            top: 90px;
            right: 30px;
            background: #7f42a7;
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 4px 24px rgba(127,66,167,0.18);
            z-index: 3000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .cart-notification.show {
            opacity: 1;
            pointer-events: auto;
        }
        @media (max-width: 900px) {
            .products-row {
                flex-direction: column;
                align-items: center;
            }
            .cart-notification {
                right: 50%;
                transform: translateX(50%);
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar-user.php'; ?>
    <div class="container">
        <div class="shop-banner">
            <h1>🛒 Shop T-Shirts</h1>
            <p>Browse our awesome t-shirt collection and add your favorites to your cart!</p>
        </div>

        <?php if (isset($_GET['added'])): ?>
            <div class="cart-notification show" id="cartNotification">
                <?php echo htmlspecialchars($_GET['added']); ?> added to cart!
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('cartNotification').classList.remove('show');
                }, 1800);
            </script>
        <?php endif; ?>

        <div class="search-box">
            <form method="get" style="display:flex;width:100%;justify-content:center;">
                <input type="text" name="search" class="search-input" placeholder="Search t-shirts..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="search-btn" type="submit">Search</button>
            </form>
        </div>

        <div class="products-row">
            <?php
            $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
            foreach ($products as $product):
                if ($search && strpos(strtolower($product['name']), $search) === false) continue;
            ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img">
                <div class="product-title"><?php echo htmlspecialchars($product['name']); ?></div>
                <div class="product-price"><del>₱<?php echo $product['oldPrice']; ?></del> <b>₱<?php echo $product['price']; ?></b></div>
                <form method="post" style="margin:0;">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <input type="hidden" name="img" value="<?php echo htmlspecialchars($product['img']); ?>">
                    <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>