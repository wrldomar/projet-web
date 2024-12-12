<?php
// Include the necessary classes
include '../../controller/productcontroller.php';
include '../../config/config.php';
session_start();

// Get and sanitize the product ID from the query parameter
$productId = filter_input(INPUT_GET, 'id_product', FILTER_VALIDATE_INT);

if (!$productId) {
    echo "Invalid Product ID.";
    exit;
}

// Initialize the ProductController
$productController = new ProductController();

// Fetch product details
$product = $productController->getProductById($productId);

if (!$product) {
    echo "Product not found.";
    exit;
}

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $userName = htmlspecialchars(trim($_POST['user_name']));
    $commentText = htmlspecialchars(trim($_POST['comment']));
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

    if (!empty($userName) && !empty($commentText)) {
        try {
            // Get PDO connection from config class
            $pdo = config::getConnexion();

            // Insert new comment with rating into the database
            $stmt = $pdo->prepare("INSERT INTO product_comments (id_product, user_name, comment, rating) VALUES (?, ?, ?, ?)");
            $stmt->execute([$productId, $userName, $commentText, $rating]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Redirect after form submission to avoid duplicate posting
    header("Location: " . $_SERVER['PHP_SELF'] . "?id_product=" . $productId);
    exit;
}

// Fetch all comments for the product
try {
    // Get PDO connection from config class
    $pdo = config::getConnexion();

    $stmt = $pdo->prepare("SELECT * FROM product_comments WHERE id_product = ? ORDER BY created_at DESC");
    $stmt->execute([$productId]);
    $comments = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $comments = [];
}
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information</title>
    <link rel="stylesheet" href="header.css">
    


    <style>
/* General Styles */

/* General Styles */
body {
    font-family: 'Roboto', Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    overflow-y: auto; /* Allow scrolling */
}


/* Marketplace Container */
.product-detail-container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 30px;
    display: flex;
    gap: 30px;
    background: linear-gradient(145deg, #d1f3e0, #a8e4c7); /* Soft green gradient */
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-detail-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}




/* Product Image */
.product-image {
    flex: 1.5;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background: #f7f7f7;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-image img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 12px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image img:hover {
    transform: scale(1.05);
}

/* Product Info */
.product-info {
    flex: 2;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 25px;
}

.product-info h2 {
    font-size: 2.5rem;
    color: #222;
    margin: 0;
    font-weight: 700;
    letter-spacing: 0.5px;
    line-height: 1.3;
}

.product-price {
    font-size: 1.8rem;
    color: #27ae60;
    font-weight: 600;
}

.product-quantity {
    font-size: 1.2rem;
    color: #555;
}

/* Quantity Input */
label {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
    display: inline-block;
}

input[type="number"] {
    width: 100px;
    padding: 10px;
    font-size: 1.1rem;
    border: 2px solid #ddd;
    border-radius: 10px;
    text-align: center;
    background-color: #f7f7f7;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

input[type="number"]:focus {
    border-color: #27ae60;
    background-color: #fff;
}

/* Total Price */
#total-price {
    font-size: 1.5rem;
    color: #222;
    font-weight: bold;
    margin-top: 10px;
}

/* Add to Cart Button */
.add-to-cart-btn {
    background-color: #27ae60;
    color: white;
    font-size: 1.2rem;
    padding: 15px 25px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.add-to-cart-btn:hover {
    background-color: #219150;
    transform: translateY(-3px);
}

.add-to-cart-btn:focus {
    outline: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-detail-container {
        flex-direction: column;
        padding: 20px;
    }

    .product-image {
        margin-bottom: 20px;
    }

    .product-info h2 {
        font-size: 2rem;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 15px 0;
        font-size: 1.1rem;
    }
}







/* General Comments Container */
.comments-section {
    width: 100%;
    max-width: 800px;
    margin: 20px auto;
    padding: 25px;
    background-color: #ffffff; /* White background for contrast */
    border-radius: 12px;
    border: 2px solid #e0e0e0; /* Light border to make it stand out */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Adding shadow for depth */
    background-color: #ffffff; /* Ensuring background is white for high contrast */
}

/* Individual comment block */
.comment {
    display: block;
    padding: 20px;
    background-color: #fafafa; /* Light grey background for each comment */
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #ddd; /* Light border for each comment */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* On hover, change background color and shadow */
.comment:hover {
    background-color: #f0f0f0; /* Slightly darker grey */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* User name styling */
.comment .user-name {
    font-size: 18px;
    font-weight: bold;
    color: #333; /* Darker color for the name */
    margin-bottom: 10px;
    text-transform: capitalize;
}

/* Comment text styling */
.comment .comment-text {
    font-size: 14px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 12px;
}

/* Comment timestamp */
.comment .timestamp {
    font-size: 12px;
    color: #999;
    text-align: right;
    margin-top: 10px;
}

/* Comment form container */
.comment-form {
    width: 100%;
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Form input fields */
.comment-form input[type="text"],
.comment-form textarea {
    width: 100%;
    padding: 15px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    color: #333;
    background-color: #f7f7f7;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

/* Focus styles for input fields */
.comment-form input[type="text"]:focus,
.comment-form textarea:focus {
    border-color: #4CAF50; /* Green border when focused */
    background-color: #fff;
    outline: none;
}

/* Submit button style */
.comment-form input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 12px 20px;
    border: none;
    font-size: 16px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s, transform 0.3s;
}

.comment-form input[type="submit"]:hover {
    background-color: #45a049;
    transform: translateY(-3px);
}

.comment-form input[type="submit"]:active {
    transform: translateY(0);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .comment-form,
    .comments-section {
        padding: 15px;
    }

    .comment {
        padding: 15px;
    }

    .comment .user-name {
        font-size: 16px;
    }

    .comment .comment-text {
        font-size: 13px;
    }

    .comment .timestamp {
        font-size: 11px;
    }

    .comment-form input[type="text"],
    .comment-form textarea {
        padding: 12px;
    }
}

/* Comment Section Title */
.comments-title {
    font-size: 24px;
    font-weight: bold;
    color: #45a049; /* Dark text for visibility */
    text-align: center;
    margin-bottom: 20px;
    text-transform: uppercase; /* Capitalize the text */
    border-bottom: 2px solid #4CAF50; /* Green underline for emphasis */
    padding-bottom: 5px;
    letter-spacing: 1px;
}




/* Rating stars */
.rating label {
    font-size: 1.2rem;
    margin-right: 10px;
}

.rating input {
    margin-right: 5px;
}

.rating-display {
    font-size: 1.5rem;
    color: #f39c12; /* Gold color for the stars */
}












.star-rating {
    font-size: 24px;
    color: gold;
    cursor: pointer;
}

.star {
    display: inline-block;
    padding: 5px;
}

.star:hover {
    color: #ffcc00;
}

.star-rating span:hover,
.star-rating span.selected {
    color: #ffcc00;
}


.star-rating {
    display: inline-flex;
    align-items: center;
    font-size: 2rem;
    cursor: pointer;
    color: gold;
}

.rating-text {
    font-weight: bold;
    margin-left: 10px;
}


    </style>

    
</head>
<body>

<!-- Header Section -->
<header id="header">
    <div class="header-content">
        <div class="left-content">
            <a href="../dashboard/dashboard.html" class="logo-link">
                <img src="Group 6.png" alt="Logo" class="logo-img">
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
                    <img src="Group 8.png" alt="User Options" class="logo-img">
                </a>
                <div class="dropdown-menu">
                    <a href="../user/signup.html" class="dropdown-link">Sign Up</a>
                    <a href="../user/login.html" class="dropdown-link">Log In</a>
                </div>
            </div>
            <a href="../panier/index.html" class="logo-link">
                <img src="Group 7.png" alt="Cart" class="logo-img">
            </a>
        </div>
    </div>
</header>

<!-- Main Content -->
<main>
    <div class="product-detail-container">
        <!-- Left: Product Image -->
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['product_image']); ?>" alt="Product Image">
        </div>

        <!-- Right: Product Details -->
        <div class="product-info">
            <h2><?= htmlspecialchars($product['name_product']); ?></h2>
            <p class="product-price">
                <?= htmlspecialchars(number_format($product['product_price'], strpos($product['product_price'], '.00') !== false ? 0 : 2)) . " Millimes per KG"; ?>
            </p>
            <p class="product-quantity">Available: <?= htmlspecialchars($product['quantite']); ?> KG</p>

            <!-- Quantity Selector -->
            <form method="POST">
                <input type="hidden" name="id_product" value="<?= htmlspecialchars($product['id_product']); ?>">
                <label for="quantity">Choose Quantity (KG):</label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="1"
                    max="<?= htmlspecialchars($product['quantite']); ?>"
                    value="1"
                    onchange="updateTotalPrice(<?= $product['product_price']; ?>)">
                <p id="total-price">Total: <?= htmlspecialchars(number_format($product['product_price'], 2)); ?> Millimes</p>
                <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
            </form>
        </div>
    </div>





<!-- Comments Section -->
<div class="comments-section">
    <h2 class="comments-title">Comment Section</h2> <!-- Title for the comment section -->
    <!-- Displaying the comments -->
    <!-- Displaying the comments -->
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <div class="user-name"><?= htmlspecialchars($comment['user_name']) ?></div>
        <div class="comment-text"><?= nl2br(htmlspecialchars($comment['comment'])) ?></div>

        <!-- Star rating display -->
        <div class="rating-display">
            <?php
            $rating = (int) $comment['rating'];
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $rating ? '★' : '☆';
            }
            ?>
        </div>

        <div class="timestamp"><?= $comment['created_at'] ?></div>
    </div>
<?php endforeach; ?>
</div>




<!-- Comment Form -->
<div class="comment-form">
    <form method="POST" action="">
        <input type="text" name="user_name" placeholder="Your Name" required>
        <textarea name="comment" placeholder="Write your comment..." required></textarea>

        <!-- Star rating display (for selection) -->
            <div class="star-rating">
                <label for="rating" class="rating-label">Rate this product:</label>
                <span class="star" data-value="1">☆</span>
                <span class="star" data-value="2">☆</span>
                <span class="star" data-value="3">☆</span>
                <span class="star" data-value="4">☆</span>
                <span class="star" data-value="5">☆</span>
            </div>
            <input type="hidden" name="rating" id="rating" value="0">
            <br>
            <input type="submit" value="Post Comment">

    </form>
</div>




</main>


<script>
    function updateTotalPrice(pricePerKg) {
        const quantityInput = document.getElementById('quantity');
        const totalPriceDisplay = document.getElementById('total-price');
        const quantity = parseFloat(quantityInput.value) || 1;
        const totalPrice = (quantity * pricePerKg).toFixed(2);
        
        // Remove trailing zeros after the decimal point
        const formattedPrice = parseFloat(totalPrice).toLocaleString('en', { maximumFractionDigits: 2 });
        
        totalPriceDisplay.textContent = `Total: ${formattedPrice} Millimes`;
    }
    








    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            document.getElementById('rating').value = value;
            stars.forEach(s => {
                s.style.color = s.getAttribute('data-value') <= value ? 'gold' : 'gray';
            });
        });
    });





document.addEventListener('DOMContentLoaded', function () {
    // Get all the stars
    const stars = document.querySelectorAll('.star');

    // Loop through all the stars and add event listeners
    stars.forEach(star => {
        star.addEventListener('click', function () {
            // Get the rating value from the clicked star's data-value attribute
            const rating = this.getAttribute('data-value');

            // Update the hidden input with the rating value
            document.getElementById('rating').value = rating;

            // Change the appearance of the stars
            stars.forEach(s => s.textContent = '☆'); // Reset all stars to empty
            for (let i = 0; i < rating; i++) {
                stars[i].textContent = '★'; // Fill up to the clicked star
            }
        });
    });
});






</script>


</body>
</html>
