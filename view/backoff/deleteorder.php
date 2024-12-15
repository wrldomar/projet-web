<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idcommande'])) {
    $idcommande = intval($_POST['idcommande']); // Securely cast to integer

    try {
        // Establish the database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the DELETE query
        $stmt = $conn->prepare("DELETE FROM commande WHERE idcommande = :idcommande");
        $stmt->bindParam(':idcommande', $idcommande, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect back to the order list page with a success message
            header("Location: displaycommande.php?message=OrderDeleted");
            exit;
        } else {
            echo "Error: Unable to delete the order.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please provide an order ID.";
}
?>
