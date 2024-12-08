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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>


<body>
<div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-google'></i>
      <a href="../../../../home/view/front office/home.html" class="logo-link">
      <span class="logo_name">GreenHarvest</span>
      </a>
    </div>
    <ul class="nav-links">
 
      <li>
        <a href="./listproduct.php" class="nav-link" id="product-link">
          <i class='bx bx-box' ></i>
          <span class="links_name">Product</span>
        </a>
      </li>

      <!-- Categories Link -->
      <li>
        <a href="listCategorie.php">
          <i class='bx bx-category' ></i>
          <span class="links_name">Categories</span>
        </a>
      </li>
    </ul>
  </div>

    <div class="home-content">
        <h1>Product Deletion</h1>
        <p>Product deleted successfully. You can return to the <a href="listProduct.php">product list</a>.</p>
    </div>

</body>
</html>
