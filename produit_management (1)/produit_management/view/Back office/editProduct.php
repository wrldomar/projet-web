<?php
// Include necessary files (e.g., for the controller and configuration)
include '../../controller/productcontroller.php';

$productController = new ProductController();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_product = $_GET['id'];
    $id_farmer = $_POST['id_farmer'];
    $id_categorie = $_POST['id_categorie'];
    $name_product = $_POST['name_product'];
    $prduct_price = $_POST['product_price'];
    $quantite = $_POST['quantite'];
    $product_image = null;

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir('../Front office/'.$uploadDir)) {
            mkdir('../Front office/'.$uploadDir, 0777, true);
        }
        $imageTmpName = $_FILES['product_image']['tmp_name'];
        $imageName = basename($_FILES['product_image']['name']);
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;
        if (move_uploaded_file($imageTmpName, '../Front office/'.$imagePath)) {
            $product_image = $imagePath;
        }
    }

    if (!$product_image) {
        $product_image = $productController->getProductImageById($id_product);
    }

    if ($productController->updateProduct($id_product, $id_farmer, $id_categorie, $name_product, $prduct_price, $quantite, $product_image)) {
        echo "Product updated successfully!";
        header('Location: listproduct.php');
        exit;
    } else {
        echo "Error updating product!";
    }
} else {
    $id_product = $_GET['id'];
    $product = $productController->getProductById($id_product);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        form {
            background-color: #ffffff;
            border: 1px solid #d1e7dd;
            border-radius: 10px;
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2d6a4f;
        }
        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #95d5b2;
            border-radius: 5px;
            background-color: #f7fcf8;
        }
        form button {
            background-color: #40916c;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #2d6a4f;
        }
    </style>
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
    <form action="editProduct.php?id=<?php echo $product['id_product']; ?>" method="POST" enctype="multipart/form-data">
        <label for="id_farmer">Farmer ID</label>
        <input type="text" name="id_farmer" id="id_farmer" value="<?php echo $product['id_farmer']; ?>" >

        <label for="id_categorie">Category ID</label>
        <input type="text" name="id_categorie" id="categorie" value="<?php echo $product['id_categorie']; ?>" >

        <label for="name_product">Product Name</label>
        <input type="text" name="name_product" id="id_product" value="<?php echo $product['name_product']; ?>" >

        <label for="prduct_price">Product Price</label>
        <input type="number" step="0.01" name="product_price" id="product_price" value="<?php echo $product['product_price']; ?>" >

        <label for="quantite">Quantity</label>
        <input type="number" name="quantite" id="quantite" value="<?php echo $product['quantite']; ?>" >

        <label for="product_image">Product Image</label>
        <input type="file" name="product_image" id="product_image" accept="image/*">
        <img id="imagePreview" src="" alt="Image preview" style="max-width: 200px; display: none;">


        <button type="submit">Update Product</button>
    </form>
    <div id="formAlert" style="color: red; display: none; margin-top: 10px; font-weight: bold;"></div>


<script>
    // Image preview function
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('imagePreview');
        preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

// Form validation function
function validateForm() {
    const id_farmer = document.getElementById('id_farmer').value;
    const id_categorie = document.getElementById('categorie').value;
    const name_product = document.getElementById('id_product').value;
    const product_price = document.getElementById('product_price').value;
    const quantite = document.getElementById('quantite').value;

    if (!id_farmer || !id_categorie || !name_product || !product_price || !quantite) {
        alert("Please fill out all the fields.");
        return false;
    }
    
    // Additional validation for price and quantity (numeric and non-negative)
    if (parseFloat(product_price) <= 0) {
        alert("Product price must be greater than 0.");
        return false;
    }
    if (parseInt(quantite) <= 0) {
        alert("Quantity must be greater than 0.");
        return false;
    }

    return true;
}

// Attach the validation function to the form
document.querySelector('form').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();  // Prevent form submission if validation fails
    }
});

// Optional: For image preview, if needed, you can display the image when the user selects a file
document.getElementById('product_image').addEventListener('change', previewImage);

</script>


  
</body>
</html>
