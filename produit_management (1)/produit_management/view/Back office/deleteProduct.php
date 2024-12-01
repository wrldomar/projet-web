<?php
include '../../controller/productcontroller.php';

// Get product ID from the URL
if (isset($_GET['id'])) {
    $id_product = $_GET['id'];

    // Create an instance of the ProductController class
    $productController = new ProductController();

    // Delete the product
    if ($productController->deleteProduct($id_product)) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting the product.";
    }
    header('Location: listProduct.php'); // Redirect back to the product list
    exit();
} else {
    echo "Product ID is missing.";
}
?>

