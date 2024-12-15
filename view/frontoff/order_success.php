<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="cart.css" rel="stylesheet">
</head>
<body>
    <h1>
    <?php
        
         // Get the order ID from the URL
          $orderId = $_GET['order_id'];

          // Display order confirmation
          echo "Your order has been placed successfully! Your order ID is: " . htmlspecialchars($orderId);
        ?>
    </h1>
    <a href="displaypanier.php"><button>Return to products list</button></a>
</body>
</html>