<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idpanier'])) {
    $idpanier = intval($_POST['idpanier']); // Securely cast to integer

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute delete query
        $stmt = $conn->prepare("DELETE FROM panier WHERE idpanier = :idpanier");
        $stmt->bindParam(':idpanier', $idpanier, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect back to the main page with a success message
            header("Location: displaypanier.php?");
            exit;
        } else {
            echo "Error removing item.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
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
    <link href="products.css" rel="stylesheet">
    <title>Cart deleted</title>
</head>
<body>
    <h1>Cart deleted successfully</h1>
</body>
</html>
