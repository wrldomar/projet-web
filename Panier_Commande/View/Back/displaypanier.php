<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Fetch products
    $stmt = $conn->prepare("SELECT idpanier, quantity, prixtotal, prod.name, u.nom, u.prenom
                            FROM panier p, user u, product prod 
                            WHERE u.iduser = p.iduser
                            AND prod.id = p.idproduit;");
    $stmt->execute();
    // Fetch results as an associative array
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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
    <h1>Carts</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Product</th>
                <th>User Name</th>
                <th>User Name</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($panier)): ?>
                <?php foreach ($panier as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['idpanier']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?> Kg</td>
                        <td><?php echo htmlspecialchars($row['prixtotal']); ?> TND</td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                        <td>
                            <form action="update.php" method="get" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <button type="submit">Update</button>
                            </form>
                        </td>

                        <td>
                            <form action="delete.php" method="post" style="display:inline;">
                                <input type="hidden" name="idpanier" value="<?php echo htmlspecialchars($row['idpanier']); ?>">
                                <a href="Delete.php"></a><button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No carts found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Close the connection
$conn = null;
?>
