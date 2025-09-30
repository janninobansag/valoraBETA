<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user'])) {
    header("Location: login.php?error=unauthorized");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Valora | Home</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: black;
            color: #e7e7e7;
        }
        .sale-banner {
            background: linear-gradient(90deg, #7f42a7 0%, #6600c5 100%);
            color: #fff;
            border-radius: 18px;
            padding: 2rem 2.5rem;
            margin: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 24px rgba(127,66,167,0.15);
            letter-spacing: 1px;
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
            border: 1.5px solid #503462;
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
        .btn-buy {
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
        .btn-buy:hover {
            background: #a7a7a7;
            color: #222;
        }
        @media (max-width: 900px) {
            .products-row {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar-user.php'; ?>
    <div class="container">
        <div class="sale-banner">
            <h1>🔥 T-Shirt Mega Sale! 🔥</h1>
            <p>Welcome, <?php echo htmlspecialchars($user['firstname']); ?>! Grab your favorite t-shirts at up to <b>50% OFF</b>.<br>
            Limited time only. Shop now and upgrade your style!</p>
        </div>

        <div class="products-row">
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=400&q=80" alt="Classic White Tee" class="product-img">
                <div class="product-title">Classic White Tee</div>
                <div class="product-price"><del>₱499</del> <b>₱249</b></div>
                <a href="#" class="btn-buy">Buy Now</a>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=400&q=80" alt="Black Urban Shirt" class="product-img">
                <div class="product-title">Black Urban Shirt</div>
                <div class="product-price"><del>₱599</del> <b>₱299</b></div>
                <a href="#" class="btn-buy">Buy Now</a>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=400&q=80" alt="Graphic Tee" class="product-img">
                <div class="product-title">Graphic Tee</div>
                <div class="product-price"><del>₱699</del> <b>₱349</b></div>
                <a href="#" class="btn-buy">Buy Now</a>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1469398715555-76331a6c7fa0?auto=format&fit=crop&w=400&q=80" alt="Minimalist Tee" class="product-img">
                <div class="product-title">Minimalist Tee</div>
                <div class="product-price"><del>₱549</del> <b>₱279</b></div>
                <a href="#" class="btn-buy">Buy Now</a>
            </div>
        </div>
    </div>
</body>
</html>