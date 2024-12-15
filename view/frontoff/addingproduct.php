<?php
include '../../controller/productcontroller.php';
include '../../controller/categoriescontroller.php';

// Fetch categories from the database
$categoriesController = new CategoriesController();
$categoriesList = $categoriesController->listcategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_farmer = intval($_POST['id_farmer']);
    $id_categorie = intval($_POST['id_categorie']);
    $name_product = trim($_POST['name_product']);
    $product_price = floatval($_POST['product_price']);
    $quantite = intval($_POST['quantite']);

    // Handle the image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory to store uploaded images
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        $imageTmpName = $_FILES['product_image']['tmp_name'];
        $imageName = basename($_FILES['product_image']['name']);
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;

        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $product_image = $imagePath;
        } else {
            $product_image = null; // Handle upload failure
        }
    }

    // CAPTCHA verification
    $captchaSecret = '6LfHbY8qAAAAAA8OOa9_QHNHN0ValacPFE_Wiixo'; // Replace with your actual secret key
    $captchaResponse = $_POST['g-recaptcha-response'];

    // Verify CAPTCHA with Google
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$captchaSecret&response=$captchaResponse";
    $verifyResponse = file_get_contents($verifyUrl);
    $responseKeys = json_decode($verifyResponse, true);

    // If CAPTCHA is not successful
    if ($responseKeys['success'] == false) {
        $message = "Captcha verification failed. Please try again.";
    } else {
        // Create Product object
        $newProduct = new Product(null, $id_farmer, $id_categorie, $name_product, $product_price, $quantite);
        $newProduct->setProductImage($product_image);

        // Add Product to Database
        $productController = new ProductController();
        if ($productController->addProduct($newProduct)) {
            $message = "Product added successfully!";
        } else {
            $message = "Failed to add product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Add Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!-- Header -->
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
                        <a href="../produit_management/view/Front office/addingproduct.php" class="dropdown-link">Sell Product</a>
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

    <!-- Product Form -->
    <form action="addingproduct.php" method="POST" enctype="multipart/form-data">
        <h2>Add New Product</h2>
        <div class="form-group">
            <label for="id_farmer"><i class="fas fa-user"></i> Farmer ID:</label>
            <input type="number" id="id_farmer" name="id_farmer" >
        </div>
        <div class="form-group">
            <label for="id_categorie"><i class="fas fa-list-alt"></i> Category:</label>
            <select id="id_categorie" name="id_categorie" >
                <option value="">Select a category</option>
                <?php
                foreach ($categoriesList as $category) {
                    echo "<option value='" . htmlspecialchars($category['id_categorie']) . "'>" . htmlspecialchars($category['categorie_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name_product"><i class="fas fa-cogs"></i> Product Name:</label>
            <input type="text" id="name_product" name="name_product" >
        </div>
        <div class="form-group">
            <label for="product_price"><i class="fas fa-dollar-sign"></i> Product Price per Kilo (MILLIMES):</label>
            <input type="number" step="0.01" id="product_price" name="product_price" >
        </div>
        <div class="form-group">
            <label for="quantite"><i class="fas fa-box"></i> Quantity (KG):</label>
            <input type="number" id="quantite" name="quantite" >
        </div>
        <div class="form-group">
            <label for="product_image"><i class="fas fa-image"></i> Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">
        </div>
        
        <!-- Google reCAPTCHA -->
        <div class="g-recaptcha" data-sitekey="6LfHbY8qAAAAAM07Z9-qQqHnKLmiCxMCmUJ2ER-y"></div>

        <button type="submit" class="submit-btn">Add Product</button>
    </form>

    <!-- Displaying the success/failure message below the form -->
    <?php if (isset($message)): ?>
        <div class="alert <?php echo ($message === "Product added successfully!") ? 'success' : 'failure'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</body>
</html>
