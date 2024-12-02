<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idpanier'])) {
    $idpanier = intval($_GET['idpanier']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the current data for the specified idpanier
        $stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal FROM panier WHERE idpanier = :idpanier");
        $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);
        $stmt->execute();

        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$cartItem) {
            die("Cart item not found.");
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idpanier'])) {
    $idpanier = intval($_POST['idpanier']);
    $quantity = intval($_POST['quantity']);
    $prixtotal = floatval($_POST['prixtotal']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the cart item's quantity and prixtotal
        $stmt = $conn->prepare("UPDATE panier SET quantity = :quantity, prixtotal = :prixtotal WHERE idpanier = :idpanier");
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':prixtotal', $prixtotal, PDO::PARAM_STR);
        $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect back to the main page with a success message
            header("Location: displaypanier.php?message=Item updated successfully");
            exit;
        } else {
            echo "Error updating item.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Cart Item</title>
</head>
<body>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($cartItem)): ?>
        <h1>Update Cart Item</h1>
        <form action="update.php" method="post">
            <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($cartItem['idpanier']); ?>">

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($cartItem['quantity']); ?>" min="1" required>
            <br>

            <label for="prixtotal">Total Price (TND):</label>
            <input type="number" step="0.01" id="prixtotal" name="prixtotal" value="<?php echo htmlspecialchars($cartItem['prixtotal']); ?>" required>
            <br>

            <button type="submit">Update</button>
            <button><a href="displaypanier.php">Cancel</a></button>
        </form>
    <?php endif; ?>
</body>
</html>
