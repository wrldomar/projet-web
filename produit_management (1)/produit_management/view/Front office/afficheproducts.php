<?php
include '../../controller/productcontroller.php';
session_start();

// Get the category ID from the query parameter
$id_categorie = isset($_GET['id_categorie']) ? intval($_GET['id_categorie']) : null;

// Get the search query from the GET request
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination parameters
$limit = 10; // Number of products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page (default is 1)
$offset = ($page - 1) * $limit; // Calculate the offset

$productController = new ProductController();

// Get products
$products = $productController->listProductsByCategory($id_categorie, $searchQuery, $limit, $offset);

// Get total number of products for pagination
$totalProducts = $productController->countProducts($searchQuery);
$totalPages = ceil($totalProducts / $limit); // Total number of pages


// Function to handle adding the product to the cart
function addProductToCart($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $productId;
}
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

<style>
    /* Styling for product grid */
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-around;
        margin-top: 30px;
    }

    /* Styling for each product card */
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 250px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: scale(1.05);
    }

    .product-img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
    }

    .product-details h3 {
        font-size: 18px;
        margin: 10px 0;
        font-weight: bold;
    }

    .price {
        color: #4caf50;
        font-size: 16px;
        font-weight: bold;
    }

    .quantity {
        font-size: 14px;
        color: #555;
        margin-bottom: 15px;
    }

    .btn-add-to-cart {
        background-color: #4caf50;
        color: white;
        padding: 10px;
        border: none;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-add-to-cart:hover {
        background-color: #45a049;
    }

    .recaptcha-container {
        display: none;
        margin-top: 10px;
    }

    .success-message, .error-message {
        padding: 10px;
        margin-top: 20px;
        background-color: #dff0d8;
        border: 1px solid #d0e9c6;
        color: #3c763d;
        border-radius: 5px;
    }

    .error-message {
        background-color: #f2dede;
        border: 1px solid #ebccd1;
        color: #a94442;
    }

    /* Search bar styling */
    .search-bar {
        margin: 20px auto;
        width: 100%;
        max-width: 400px;
        position: relative;
    }

    .search-bar input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 20px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    .search-bar input[type="text"]:focus {
        border-color: #4caf50;
    }

    .search-bar button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-bar button:hover {
        background-color: #45a049;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    }

    .pagination-button {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        margin: 0 5px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .pagination-button:hover {
        background-color: #45a049;
    }

    .pagination-button.disabled {
        background-color: #ddd;
        color: #aaa;
        cursor: not-allowed;
    }

    .pagination span {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .pagination a {
        display: inline-block;
        text-align: center;
        padding: 8px 12px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .pagination a:hover {
        background-color: #f0f0f0;
    }

</style>

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

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by product name..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit">
                    <span>🔍</span>
                </button>
            </form>
        </div>

        <?php if (isset($successMessage)): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($captchaError)): ?>
            <div class="error-message"><?php echo $captchaError; ?></div>
        <?php endif; ?>

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

                            <!-- Form for adding to cart with reCAPTCHA -->
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id_product']; ?>">
                                <!-- Hidden reCAPTCHA -->
                                <div id="recaptcha-<?php echo $product['id_product']; ?>" class="recaptcha-container">
                                    <div class="g-recaptcha" data-sitekey="6LfHbY8qAAAAAM07Z9-qQqHnKLmiCxMCmUJ2ER-y"></div>
                                </div>
                                <button type="submit" name="add_to_cart" class="btn-add-to-cart" onclick="showRecaptcha(<?php echo $product['id_product']; ?>)">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchQuery); ?>" class="pagination-button">Previous</a>
            <?php endif; ?>

            <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchQuery); ?>" class="pagination-button">Next</a>
            <?php endif; ?>
        </div>

    </div>
</main>

</body>
</html>
