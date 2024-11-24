<?php
include '../../controller/productcontroller.php';

// Get the category ID from the query parameter
$id_categorie = isset($_GET['id_categorie']) ? intval($_GET['id_categorie']) : null;

// Fetch products using the controller
$productController = new ProductController();
$products = $productController->listProductsByCategory($id_categorie);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fresh Products | Green Harvest</title>
    <link rel="stylesheet" href="affiche.css">
    <script src="affichep.js" defer></script>
</head>
<body>

<header id="header">
    <div class="header-content">
        <div class="left-content">
            <a href="../dashboard/dashboard.html" class="logo-link">
                <img src="Group 6.png" alt="Group 6 Logo" class="logo-img">
            </a>
            <a href="../../../../home/view/front office/home.html" class="link">Home</a>
            <div class="dropdown">
                <a href="../Shop/shop1.html" class="link">Shop</a>
                <div class="dropdown-menu">
                    <a href="../../../produit_management (1)/produit_management/view/Front office/addingproduct.php" class="dropdown-link">Sell Product</a>
                </div>
            </div>
        </div>
        <div class="logo">
            <h1><span class="green">Green</span><span class="harvest">Harvest</span></h1>
        </div>
        <div class="right-content">
            <div class="dropdown">
                <a href="#" class="link">Events</a>
                <div class="dropdown-menu">
                    <a href="../evenement/create_event.html" class="dropdown-link">Create Event</a>
                    <a href="../evenement/view_events.html" class="dropdown-link">View Events</a>
                </div>
            </div>
            <a href="../contact/contact.html" class="link">Contact</a>
            <div class="dropdown">
                <a href="#" class="logo-link">
                    <img src="Group 8.png" alt="Group 8 Logo" class="logo-img">
                </a>
                <div class="dropdown-menu">
                    <a href="../user/signup.html" class="dropdown-link">Sign Up</a>
                    <a href="../user/login.html" class="dropdown-link">Log In</a>
                </div>
            </div>
            <a href="../panier/index.html" class="logo-link">
                <img src="Group 7.png" alt="Group 7 Logo" class="logo-img">
            </a>
        </div>
    </div>
</header>

<main>
    <div class="container">

        <?php if (empty($products)): ?>
            <p class="no-products">No products available for this category.</p>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" class="product-img">
                        <div class="product-details">
                            <h3><?php echo htmlspecialchars($product['name_product']); ?></h3>
                            <p class="price"><?php echo htmlspecialchars($product['product_price']); ?> TND</p>
                            <p class="quantity"><?php echo htmlspecialchars($product['quantite']); ?> in stock</p>
                            <a href="#" class="btn-add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
