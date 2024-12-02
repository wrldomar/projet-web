<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all cart items
    $stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal, prod.name, u.nom, u.prenom
                            FROM panier p
                            JOIN user u ON u.iduser = p.iduser
                            JOIN product prod ON prod.id = p.idproduit;");
    $stmt->execute();
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idpanier'])) {
    $idpanier = intval($_POST['idpanier']);
    $idproduit = intval($_POST['idproduit']);
    $quantity = intval($_POST['quantity']);
    $product_stmt = $conn->prepare("SELECT price FROM product WHERE id = :product_id");
    $product_stmt->bindParam(':product_id', $idproduit, PDO::PARAM_INT);
    $product_stmt->execute();
    $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
    $newprice = $quantity * $product['price'];

    try {
        $stmt = $conn->prepare("UPDATE panier SET quantity = :quantity, prixtotal = :prixtotal WHERE idpanier = :idpanier");
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);
        $stmt->bindParam(':prixtotal', $newprice, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: displaypanier.php?message=Item updated successfully");
            exit;
        } else {
            echo "Error updating item.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Fetch specific item for editing
$cartItem = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idpanier'])) {
    $idpanier = intval($_GET['idpanier']);

    try {
        $stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal, idproduit FROM panier WHERE idpanier = :idpanier");
        $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);
        $stmt->execute();
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cartItem) {
            die("Cart item not found.");
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carts</title>
    <link href="products.css" rel="stylesheet">
</head>
<body>
    <h1>Cart</h1>
    <input type="text" id="searchbar" placeholder="Search products..." onkeyup="searchCart()">
    
    <!-- Display Success Message -->
    <?php if (isset($_GET['message'])): ?>
    <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    <!-- Display Success Message -->
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <!-- Update Form -->
    <?php if ($cartItem): ?>
        <h2>Update Cart Item</h2>
        <form action="displaypanier.php" method="post">
            <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($cartItem['idpanier']); ?>">
            <input type="hidden" name="idproduit" value="<?php echo htmlspecialchars($cartItem['idproduit']); ?>">

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($cartItem['quantity']); ?>" required>
            
            <br>

            <button type="submit">Update</button>
            <a href="displaypanier.php"><button type="button">Cancel</button></a>
        </form>
    <?php endif; ?>

    <!-- Display Cart Items -->
    <table>
        <thead>
            <tr>
                <th><button id="product-column" name="product-column" type="button">Product</button></th>
                <th>Quantity</th>
                <th><button id="total-column" type="button">Total</button></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($panier)): ?>
                <?php foreach ($panier as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?> Kg</td>
                        <td><?php echo htmlspecialchars($row['prixtotal']); ?> TND</td>
                        <td>
                            <form action="displaypanier.php" method="get" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <button type="submit">Update</button>
                            </form>
                            <form action="delete.php" method="post" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No carts found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="displayproducts.php"><button>Return to products list</button></a>
    <br>
    <br>
    <a href="commande.php"><button>Place Order</button></a>
    <script src="panier.js"></script>

</body>
</html>
<?php
// Close the connection
$conn = null;
?>
