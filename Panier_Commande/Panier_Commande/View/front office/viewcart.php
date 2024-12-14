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

    $stmt = $conn->prepare("SELECT name_product, idpanier, quantity, prixtotal,iduser,idcommande,p.id_product FROM panier p, products pro 
                            WHERE p.id_product=pro.id_product 
                            AND p.iduser = :user_id AND p.idcommande IS NULL");

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
        

    <h3>Are you sure you want to place order on these items ?</h3>
    
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
                    <td><?php echo htmlspecialchars($item['name_product']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?> Kg</td>
                    <td><?php echo htmlspecialchars($item['prixtotal']); ?> TND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Total Price -->
    <h3>Total: <?php echo $totalPrice; ?></h3>

    <!-- Place Order Button -->
    <form action="commande.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
        <button type="submit">Yes, Place Order</button>
    </form>
    
    <a href="displayproducts.php"><button id="remove">No, Continue Shopping</button></a>
    <script src="home.js"></script>
</body>
</html>
