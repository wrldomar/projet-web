<?php
session_start();
$userId = $_SESSION['user_id']; // Get the user's ID from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalPrice = $_POST['total_price']; // Get the total price from the form
    $userId = $_POST['user_id']; // Get the user ID from the form
    
    // Get the current date
    $currentDate = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "panier";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start the transaction to ensure the order and cart clearing happen together
        $conn->beginTransaction();

        // Insert the order into the 'commande' table
        $stmt = $conn->prepare("INSERT INTO commande (iduser, totalprice, order_date, status) VALUES (:user_id, :totalprice, :order_date, 'on hold')");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':totalprice', $totalPrice, PDO::PARAM_INT);
        $stmt->bindParam(':order_date', $currentDate, PDO::PARAM_STR);
        $stmt->execute();

        // Get the last inserted order ID
        $orderId = $conn->lastInsertId();

        // Update the panier table to link the cart items with the order ID
        $stmt = $conn->prepare("UPDATE panier SET idcommande = :idcommande WHERE iduser = :user_id AND idcommande IS NULL");
        $stmt->bindParam(':idcommande', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Clear the cart by deleting the items in the panier table for the user
        $stmt = $conn->prepare("DELETE FROM panier WHERE iduser = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Commit the transaction to apply all changes
        $conn->commit();

        // Redirect to the order success page
        header("Location: order_success.php?order_id=" . $orderId);
        exit;
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $conn->rollBack();
        die("Error: " . $e->getMessage());
    }
}
?>
