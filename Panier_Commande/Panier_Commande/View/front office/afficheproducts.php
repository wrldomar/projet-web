<?php
include '../../controller/productcontroller.php';
session_start();

// Get the category ID from the query parameter
$id_categorie = isset($_GET['id_categorie']) ? intval($_GET['id_categorie']) : null;

// Get the search query from the GET request
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination parameters
$limit = 6; // Number of products per page
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
  
    <!-- Add FontAwesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">





</head>
<body>

<style>
    body{
        background-color: #ddd;
    }
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
    gap: 10px; /* Space between pagination items */
    margin-top: 30px;
    font-family: Arial, sans-serif;
    }

    .pagination-button {
        background-color: #4caf50;
        color: #ffffff; /* Updated text color for better visibility */
        padding: 12px 18px; /* Better padding for button size */
        text-decoration: none;
        border-radius: 8px; /* Slightly more rounded for a modern look */
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease-in-out; /* Smooth hover effects */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        border: none;
        cursor: pointer;
    }

    .pagination-button:hover {
        background-color: #45a049;
        color: #ffffff; /* Maintain visibility on hover */
        transform: scale(1.05); /* Slight zoom for interactivity */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Enhance hover shadow */
    }

    .pagination-button.disabled {
        background-color: #ddd;
        color: #aaa;
        cursor: not-allowed;
        box-shadow: none;
    }

    .pagination span {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        padding: 0 10px; /* Add spacing between text and buttons */
    }

    .pagination a {
        display: inline-block;
        text-align: center;
        padding: 10px 14px;
        border-radius: 8px;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: #4caf50; /* Default link color */
        font-size: 16px;
        text-decoration: none;
        font-weight: 500;
    }

    .pagination a:hover {
        background-color: #e8f5e9; /* Soft green highlight */
        color: #388e3c; /* Darker green text for hover */
    }








    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-around;
        margin-top: 30px;
    }

    .product-grid.list-view {
        display: block;
    }



    /* Image-only view */
    .toggle-image-btn{
        position: absolute;
        top: 130px;  /* Adjust the vertical position */
        RIGHT: 130px; /* Adjust the horizontal position */

    }
    .product-grid.image-only-view {

        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Smaller columns for images */
        gap: 130px;
    }

    .product-grid.image-only-view .product-card {
        padding: 0; /* Remove padding */
        border: none; /* Remove borders */
        box-shadow: none; /* Remove shadow */
        background-color: transparent; /* No background */
    }

    .product-grid.image-only-view .product-card img {
        width: 100%; /* Images take up full width */
        height: auto;
        border-radius: 8px; /* Optional: keep image styling */
        
    }

    .product-grid.image-only-view .product-details {
        display: none; /* Hide all product details */
    }



    /* Toggle View Button */
    .view-toggle {
        text-align: center;
        margin-bottom: 20px;
    }

    .view-toggle button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .view-toggle button:hover {
        background-color: #45a049;
    }


    .toggle-grid-btn {
    position: absolute;
    top: 130px;  /* Adjust the vertical position */
    RIGHT: 50px; /* Adjust the horizontal position */
    background-color: #4caf50;
    color: white;
    padding: 10px;
    border: none;
    font-size: 24px;  /* Adjust font size for the icon */
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
 
}

.toggle-grid-btn:hover {
    background-color: #45a049;
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
                <a href="./listcategories.php" class="link">Shop</a>
            <div class="dropdown-menu">
                <a href="./addingproduct.php" class="dropdown-link">Sell Product</a>
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


        <!-- Toggle Buttons -->
        <div class="view-toggle">
            <!-- Grid view button -->
            <button class="toggle-grid-btn" onclick="toggleGrid()">
                <i class="fas fa-th"></i>
            </button>

            <!-- Image-only view button -->
            <button class="toggle-image-btn" onclick="toggleImageView()">
                <i class="fas fa-images"></i>
            </button>
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
                                    <a href="infoProduct.php?id_product=<?php echo $product['id_product']; ?>">
                                        <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" class="product-img">
                                    </a>
                                    <div class="product-details">
                                        <h3><?php echo htmlspecialchars($product['name_product']); ?></h3>
                                        <p class="price">
                                            <?php 
                                            $price = $product['product_price'];
                                            // Remove trailing .00 if present
                                            if (strpos($price, '.00') !== false) {
                                                $price = number_format($price, 0, '', '');
                                            }
                                            echo htmlspecialchars($price) . " Millimes per Kilo"; 
                                            ?>
                                        </p>
                                        <p class="quantity"><?php echo htmlspecialchars($product['quantite']); ?> KG</p>

                                        <!-- Form for adding to cart with reCAPTCHA -->
                                        <form method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id_product']; ?>">
                                            <div id="recaptcha-<?php echo $product['id_product']; ?>" class="recaptcha-container">
                                                <div class="g-recaptcha" data-sitekey="6LfHbY8qAAAAAM07Z9-qQqHnKLmiCxMCmUJ2ER-y"></div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination Controls -->
        <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?id_categorie=<?php echo $id_categorie; ?>&page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchQuery); ?>" class="pagination-button">Previous</a>
    <?php endif; ?>

    <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?id_categorie=<?php echo $id_categorie; ?>&page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchQuery); ?>" class="pagination-button">Next</a>
    <?php endif; ?>
</div>


    </div>
</main>

</body>


<script>
function toggleGrid() {
    var grid = document.querySelector('.product-grid');

    if (grid.classList.contains('list-view')) {
        // Switch to grid view
        grid.classList.remove('list-view');
        grid.classList.remove('image-only-view');
        grid.classList.add('grid-view');
    } else {
        // Switch to list view
        grid.classList.add('list-view');
        grid.classList.remove('grid-view');
        grid.classList.remove('image-only-view');
    }
}

function toggleImageView() {
    var grid = document.querySelector('.product-grid');

    if (grid.classList.contains('image-only-view')) {
        // Switch back to normal grid view
        grid.classList.remove('image-only-view');
        grid.classList.add('grid-view');
    } else {
        // Enable image-only view
        grid.classList.add('image-only-view');
        grid.classList.remove('list-view');
        grid.classList.remove('grid-view');
    }
}



    </script>
</html>
