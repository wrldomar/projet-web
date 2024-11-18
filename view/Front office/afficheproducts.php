<?php

include '../../controller/productcontroller.php';

// Get the category ID from the query parameter
$id_categorie = isset($_GET['id_categorie']) ? intval($_GET['id_categorie']) : null;

// Fetch products using the controller
$productController = new ProductController();
$products = $productController->listProductsByCategory($id_categorie);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Products</h1>
    <a href="listcategories.php">Back to Categories</a>

    <?php if (empty($products)): ?>
        <p>No products available for this category.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name_product']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_price']); ?> USD</td>
                        <td><?php echo htmlspecialchars($product['quantite']); ?></td>
                        <td>
                            <?php if (!empty($product['product_image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
