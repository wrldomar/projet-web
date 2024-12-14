<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = 1; // Replace with the logged-in user's ID (adjust as necessary)

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the product already exists in the cart for the user
        $stmt = $conn->prepare("SELECT idpanier, quantity FROM panier WHERE id_product = :product_id AND iduser = :user_id");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // If product does not exist in the cart, add it
        $product_stmt = $conn->prepare("SELECT product_price FROM products WHERE id_product = :product_id");
        $product_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $product_stmt->execute();
        $product = $product_stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            // If product exists in the cart, update the quantity
            $new_quantity = $cart_item['quantity'] + 1;
            $new_price = $new_quantity * $product['product_price'];
            $update_stmt = $conn->prepare("UPDATE panier SET quantity = :quantity, prixtotal = :prixtotal WHERE idpanier = :idpanier");
            $update_stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
            $update_stmt->bindParam(':prixtotal', $new_price, PDO::PARAM_INT);
            $update_stmt->bindParam(':idpanier', $cart_item['idpanier'], PDO::PARAM_INT);
            $update_stmt->execute();
        } else {
            
            if ($product) {
                $price = $product['product_price'];
                $insert_stmt = $conn->prepare("INSERT INTO panier (id_product , iduser, quantity, prixtotal) VALUES (:product_id, :user_id, 1, :price)");
                $insert_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $insert_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $insert_stmt->bindParam(':price', $price, PDO::PARAM_STR);
                $insert_stmt->execute();
            } else {
                die("Product not found.");
            }
        }

        // Redirect back to the product list with a success message
        header("Location: displayproducts.php?message=Product added to cart successfully");
        exit;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>
