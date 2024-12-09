<?php
// Check if user_id is passed in the URL
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo "User ID is required to view the cart.";
    exit;
}

$userId = intval($_GET['user_id']); // Get the user_id from the query parameter

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user's cart items
    $stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal, prod.name
                            FROM panier p
                            JOIN product prod ON prod.id = p.idproduit
                            WHERE p.iduser = :user_id AND p.idcommande IS NULL");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <html>
        <head>
            <link href="cart.css" rel="stylesheet">
        </head>
        <body>
            <h1>
                <?php
                    if (count($cartItems) === 0) {
                        echo "Your cart is empty.";
                        ?>
                </h1>
                <a href="displayproducts.php"><button id="rtpl">Return to products list</button></a>
                <?php 
                    exit;
            
                }
               ?>
            
        </body>
    </html>

    <?php
    // Calculate the total price
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['prixtotal'];
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="cart.css" rel="stylesheet">
</head>
<body>
    <h1>Are you sure you want to place order on these items ?</h1>
    
    <!-- Cart Table -->
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price (TND)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?> Kg</td>
                    <td><?php echo htmlspecialchars($item['prixtotal']); ?> TND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Total Price -->
    <h2>Total: <?php echo $totalPrice; ?> TND</h2>

    <!-- Place Order Button -->
    <form action="commande.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
        <button type="submit">Place Order</button>
    </form>
    
    <br>
    <a href="displayproducts.php"><button>Continue Shopping</button></a>
</body>
</html>
