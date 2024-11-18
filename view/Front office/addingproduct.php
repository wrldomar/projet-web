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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form div {
            margin-bottom: 10px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input, form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin: 10px 0;
            font-size: 1.2em;
            color: green;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Add Product</h1>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="addingproduct.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="id_farmer">Farmer ID:</label>
            <input type="number" id="id_farmer" name="id_farmer" required>
        </div>
        <div>
            <label for="id_categorie">Category:</label>
            <select id="id_categorie" name="id_categorie" required>
                <option value="">Select a category</option>
                <?php
                foreach ($categoriesList as $category) {
                    echo "<option value='" . htmlspecialchars($category['id_categorie']) . "'>" . htmlspecialchars($category['categorie_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="name_product">Product Name:</label>
            <input type="text" id="name_product" name="name_product" required>
        </div>
        <div>
            <label for="product_price">Product Price:</label>
            <input type="number" step="0.01" id="product_price" name="product_price" required>
        </div>
        <div>
            <label for="quantite">Quantity:</label>
            <input type="number" id="quantite" name="quantite" required>
        </div>
        <div>
            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" required>
        </div>
        <button type="submit">Add Product</button>
    </form>

</body>
</html>
