<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all cart items
//$stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal,iduser,idcommande,id_product FROM panier");
$stmt = $conn->prepare("SELECT name_product, idpanier, quantity, prixtotal,iduser,idcommande,p.id_product FROM panier p, products pro WHERE p.id_product=pro.id_product");

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
            header("Location: displaypanier.php?");
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
        $stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal, id_product FROM panier WHERE idpanier = :idpanier");
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
    <link href="cart.css" rel="stylesheet">
    <link href="front.css" rel="stylesheet">
    
</head>
<body>
<div id="main-content">
        <header id="header">
            <div class="header-content">
                <div class="left-content">
                    <a href="../dashboard/dashboard.html" class="logo-link">
                        <img src="assets/Group 6.png" alt="Group 6 Logo" class="logo-img">
                    </a>
                    <a href="../Home/home.html" class="link">Home</a>
                    <div class="dropdown">
                        <a href="../Shop/shop1.html" class="link">Shop</a>
                        <div class="dropdown-menu">
                            <a href="../produit_management/view/Front office/addingproduct.php" class="dropdown-link">Sell Product</a>
                        </div>
                    </div>
                    
                </div>
                <div class="logo">
                    <h1><span class="green">Green</span><span class="harvest">Harvest</span></h1>
                </div>
                <div class="right-content">
                    <div class="dropdown">
                        <a href="#" class="link">Events</a>
                        <div class="dropdown-menu">
                            <a href="../evenement/create_event.html" class="dropdown-link">Create Event</a>
                            <a href="../evenement/view_events.html" class="dropdown-link">View Events</a>
                        </div>
                    </div>
                    <a href="../contact/contact.html" class="link">Contact</a>
                    <div class="dropdown">
                        <a href="#" class="logo-link">
                            <img src="assets/Group 8.png" alt="Group 8 Logo" class="logo-img">
                        </a>
                        <div class="dropdown-menu">
                            <a href="../user/signup.html" class="dropdown-link">Sign Up</a>
                            <a href="../user/login.html" class="dropdown-link">Log In</a>
                        </div>
                    </div>
                    <a href="displaypanier.php" class="logo-link">
                        <img src="assets/Group 7.png" alt="Group 7 Logo" class="logo-img">
                    </a>
                </div>
            </div>
        </header>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
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
            <input type="hidden" name="idproduit" value="<?php echo htmlspecialchars($cartItem['id_product']); ?>">

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
                        <td><?php echo htmlspecialchars($row['name_product']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?> Kg</td>
                        <td><?php echo htmlspecialchars($row['prixtotal']); ?> </td>
                        <td>
                            <form action="displaypanier.php" method="get" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <button type="submit">Update</button>
                            </form>
                            <form action="delete.php" method="post" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <button type="submit" id="remove">Remove</button>
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
    <a href="displayproducts.php"><button id="rtpl">Return to products list</button></a>
    <br>
    <br>
    <a href="viewcart.php?user_id=1"><button>Place Order</button></a>
    <script src="panier.js"></script>

</body>
</html>
<?php
// Close the connection
$conn = null;
?>
