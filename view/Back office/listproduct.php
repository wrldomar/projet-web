<?php
include '../../controller/productcontroller.php';

// Create an instance of the ProductController class
$productController = new ProductController();

// Retrieve all products from the database
$products = $productController->getAllProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Add any required CSS or Bootstrap links here -->
</head>
<body>

<h1>Product List</h1>

<table border="1" cellpadding="10" cellspacing="0">
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
        // Loop through each product and display it in a table row
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['id_product']) . "</td>";
            echo "<td>" . htmlspecialchars($product['id_farmer']) . "</td>";
            echo "<td>" . htmlspecialchars($product['id_categorie']) . "</td>";
            echo "<td>" . htmlspecialchars($product['name_product']) . "</td>";
            echo "<td>" . htmlspecialchars($product['product_price']) . "</td>";
            echo "<td>" . htmlspecialchars($product['quantite']) . "</td>";
            echo "<td><img src='" . htmlspecialchars('../Front office/'.$product['product_image']) . "' alt='Product Image' width='100'></td>";
            echo "<td>
                    <a href='editProduct.php?id=" . $product['id_product'] . "'>Edit</a> | 
                    <a href='deleteProduct.php?id=" . $product['id_product'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
