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
    <style>

        /* General Styling for Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }

        /* Header Styling */
        th {
            background-color: #4caf50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Row Styling */
        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Image Styling */
        td img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
        }

        /* Action Links Styling */
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

        /* Confirm Delete Styling */
        a.delete-btn {
            color: #e74c3c;
        }

        a.delete-btn:hover {
            background-color: #e74c3c;
            color: white;
        }

        /* Add some margin and padding to the page */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

    </style>
</head>
<body>

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
        // Loop through each product and display it in a table row
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
        ?>
    </tbody>
</table>

</body>
</html>
