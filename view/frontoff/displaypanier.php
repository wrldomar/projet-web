<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all cart items
    $stmt = $conn->prepare("SELECT name_product, idpanier, quantity, prixtotal, iduser, idcommande, p.id_product FROM panier p, products pro WHERE p.id_product=pro.id_product");
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
    
    // Get product price based on id
    $product_stmt = $conn->prepare("SELECT product_price FROM products WHERE id_product = :product_id");
    $product_stmt->bindParam(':product_id', $idproduit, PDO::PARAM_INT);
    $product_stmt->execute();
    $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
    $newprice = $quantity * $product['product_price'];

    try {
        $stmt = $conn->prepare("UPDATE panier SET quantity = :quantity, prixtotal = :prixtotal WHERE idpanier = :idpanier");
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);
        $stmt->bindParam(':prixtotal', $newprice, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: displaypanier.php?message=Cart updated successfully");
            exit;
        } else {
            echo "Error updating item.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Handle item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_idpanier'])) {
    $remove_idpanier = intval($_POST['remove_idpanier']);

    try {
        $stmt = $conn->prepare("DELETE FROM panier WHERE idpanier = :idpanier");
        $stmt->bindParam(':idpanier', $remove_idpanier, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: displaypanier.php?message=Item removed successfully");
            exit;
        } else {
            echo "Error removing item.";
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
    <link href="cart.css" rel="stylesheet">
    <link href="front.css" rel="stylesheet">
</head>
<body>
<div id="main-content">
    <header id="header">
        <div class="header-content">
            <!-- Header Content -->
            <div class="left-content">
                <a href="#" class="logo-link">
                    <img src="Group 6.png" alt="Group 6 Logo" class="logo-img">
                </a>
                <a href="home.html" class="link">Home</a>
                <div class="dropdown">
                    <a href="../backoff/eventacc.php" class="link">Shop</a>
                    
                </div>
            </div>
            <div class="logo">
                <h1><span class="green">Green</span><span class="harvest">Harvest</span></h1>
            </div>
            <div class="right-content">
                
                <a href="displaypanier.php" class="logo-link">
                    <img src="Group 7.png" alt="Group 7 Logo" class="logo-img">
                </a>
            </div>
        </div>
    </header>

    <h1>Cart</h1>

    <!-- Display Success Message -->
    <?php if (isset($_GET['message'])): ?>
    <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <!-- Display Cart Items -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($panier)): ?>
                <?php foreach ($panier as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name_product']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?> Kg</td>
                        <td><?php echo htmlspecialchars($row['prixtotal']); ?> </td>
                        <td>
                            <form action="displaypanier.php" method="post" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <input type="hidden" name="idproduit" value="<?php echo htmlspecialchars($row['id_product']); ?>">
                                <input type="number" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" min="1" >
                                <button type="submit">Update</button>
                            </form>
                            <form action="displaypanier.php" method="post" style="display:inline;">
                                <input type="hidden" name="remove_idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <button type="submit" style="color: red;">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Your cart is empty!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="afficheproducts.php"><button id="rtpl">Return to products list</button></a>
    <br>
    <br>
    <a href="viewcart.php?user_id=1"><button>Place Order</button></a>
</div>

<script src="panier.js"></script>
</body>
</html>

<?php
// Close the connection
$conn = null;
?>
