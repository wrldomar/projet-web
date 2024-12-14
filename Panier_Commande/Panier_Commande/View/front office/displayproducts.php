<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "panier"; // Your database name

try {
    // Connect to the database using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the 'products' table
    $stmt = $conn->prepare("SELECT id_product, id_farmer, id_categorie, name_product, product_price, quantite, product_image FROM products");
    $stmt->execute();

    // Fetch all rows as an associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Table</title>
    <link rel="stylesheet" href="products.css"> <!-- Optional: Link to your CSS file -->
</head>
<body>
    <h1>Products Table</h1>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Farmer ID</th>
                <th>Category ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id_product']); ?></td>
                        <td><?php echo htmlspecialchars($product['id_farmer']); ?></td>
                        <td><?php echo htmlspecialchars($product['id_categorie']); ?></td>
                        <td><?php echo htmlspecialchars($product['name_product']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_price']); ?></td>
                        <td><?php echo htmlspecialchars($product['quantite']); ?></td>
                        <td>
                            <?php if (!empty($product['product_image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" width="100" height="100">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="addtocart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id_product']); ?>"> 
                                <button type="submit">Add to cart</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No products found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn = null;
?>
