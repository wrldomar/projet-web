<?php
include '../../controller/productcontroller.php';

$productController = new ProductController();

// Number of products per page
$productsPerPage = 99;

// Get the current page from the URL (default to 1 if not set)
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get the search query from the URL (if provided)
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Calculate the offset for SQL query based on the current page
$offset = ($currentPage - 1) * $productsPerPage;

// Fetch products based on the search term
$products = $productController->getAllProducts($searchTerm, $productsPerPage, $offset);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>


        table {
            width: 75%;
            border-collapse: collapse;
            margin: 20px 300px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }

        th {
            background-color: #4caf50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
        }

        td a {
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        td a:hover {
            background-color: #4caf50;
            color: white;
        }

        td a:active {
            background-color: #2e8b39;
        }

        a.delete-btn {
            color: #e74c3c;
        }

        a.delete-btn:hover {
            background-color: #e74c3c;
            color: white;
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
        <a href="#" class="nav-link" id="product-link">
          <i class='bx bx-box'></i>
          <span class="links_name">Product</span>
        </a>
      </li>

      <!-- Categories Link -->
      <li>
        <a href="listCategorie.php">
          <i class='bx bx-category'></i>
          <span class="links_name">Categories</span>
        </a>
      </li>

      <!-- Comments Link -->
      <li>
        <a href="#" class="nav-link" id="comments-link">
          <i class='bx bx-message'></i>
          <span class="links_name">Comments</span>
        </a>
      </li>
    </ul>
  </div>


<h1>Product List</h1>



<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Farmer ID</th>
            <th>Category ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Product Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($products)) {
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($product['id_product']) . "</td>";
                echo "<td>" . htmlspecialchars($product['id_farmer']) . "</td>";
                echo "<td>" . htmlspecialchars($product['id_categorie']) . "</td>";
                echo "<td>" . htmlspecialchars($product['name_product']) . "</td>";
                echo "<td>" . htmlspecialchars($product['product_price']) . "</td>";
                echo "<td>" . htmlspecialchars($product['quantite']) . "</td>";
                echo "<td><img src='" . htmlspecialchars('../Front office/'.$product['product_image']) . "' alt='Product Image'></td>";
                echo "<td>
                        <a href='editProduct.php?id=" . $product['id_product'] . "'>Edit</a> | 
                        <a href='deleteProduct.php?id=" . $product['id_product'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")' class='delete-btn'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        
        }
        ?>
    </tbody>
</table>

</body>
</html>