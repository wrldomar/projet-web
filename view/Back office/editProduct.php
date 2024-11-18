<?php
// Include necessary files (e.g., for the controller and configuration)
include '../../controller/productcontroller.php';

$productController = new ProductController();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get product ID from URL or form
    $id_product = $_GET['id'];

    // Get the other fields from the form
    $id_farmer = $_POST['id_farmer'];
    $id_categorie = $_POST['id_categorie'];
    $name_product = $_POST['name_product'];
    $prduct_price = $_POST['product_price'];
    $quantite = $_POST['quantite'];
    $product_image = null; // Default to null if no image uploaded

    // Check if a new image is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory to store uploaded images

        // Create directory if it doesn't exist
        if (!is_dir('../Front office/'.$uploadDir)) {
            mkdir('../Front office/'.$uploadDir, 0777, true);
        }

        $imageTmpName = $_FILES['product_image']['tmp_name'];
        $imageName = basename($_FILES['product_image']['name']);
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;

        // Move the uploaded image to the desired directory
        if (move_uploaded_file($imageTmpName, '../Front office/'.$imagePath)) {
            $product_image = $imagePath; // Set the product image path
        } else {
            $product_image = null; // Handle upload failure
        }
    }

    // If no new image was uploaded, fetch the current image from the database
    if (!$product_image) {
        $product_image = $productController->getProductImageById($id_product); // Fetch existing image
    }

    // Call the update function
    if ($productController->updateProduct($id_product, $id_farmer, $id_categorie, $name_product, $prduct_price, $quantite, $imagePath)) {
        echo "Product updated successfully!";
        header('Location: listproduct.php');
    } else {
        echo "Error updating product!";
    }
} else {
    // If the form is not submitted, fetch the product details for editing
    $id_product = $_GET['id'];
    $product = $productController->getProductById($id_product); // Fetch the current product details
}
?>

<form action="editProduct.php?id=<?php echo $product['id_product']; ?>" method="POST" enctype="multipart/form-data">
    <label for="id_farmer">Farmer ID</label>
    <input type="text" name="id_farmer" value="<?php echo $product['id_farmer']; ?>" required><br>

    <label for="id_categorie">Category ID</label>
    <input type="text" name="id_categorie" value="<?php echo $product['id_categorie']; ?>" required><br>

    <label for="name_product">Product Name</label>
    <input type="text" name="name_product" value="<?php echo $product['name_product']; ?>" required><br>

    <label for="prduct_price">Product Price</label>
    <input type="number" step="0.01" name="product_price" value="<?php echo $product['product_price']; ?>" required><br>

    <label for="quantite">Quantity</label>
    <input type="number" name="quantite" value="<?php echo $product['quantite']; ?>" required><br>

    <label for="product_image">Product Image</label>
    <input type="file" name="product_image" accept="image/*"><br>

    <button type="submit">Update Product</button>
</form>
