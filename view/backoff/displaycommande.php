<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch orders from the 'commande' table
    $stmt = $conn->prepare("SELECT idcommande, iduser, totalprice, status, order_date FROM commande");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Order List</title>
    <link rel="stylesheet" href="orders.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
      <div class="logo-details">
        <i class="bx bxl-google"></i>
        <a href="../frontoff/home.html" class="logo-link">
          <span class="logo_name">GreenHarvest</span>
        </a>
      </div>
      <ul class="nav-links">
        <li>
          <a href="listreclamation.php" class="active">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">listreclamation</span>
          </a>
        </li>
        <li>
          <a href="listCategorie.php">
            <i class="bx bx-box"></i>
            <span class="links_name">Categories</span>
          </a>
        </li>
        <li>
          <a href="list.php">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">user</span>
          </a>
        </li>
        <li>
          <a href="listproduct.php">
            <i class="bx bx-coin-stack"></i>
            <span class="links_name">Product</span>
          </a>
        </li>
        <li>
          <a href="listreponse.php">
            <i class="bx bx-book-alt"></i>
            <span class="links_name">reponse</span>
          </a>
        </li>
        <li>
          <a href="chart.php">
            <i class="bx bx-user"></i>
            <span class="links_name">chart</span>
          </a>
        </li>
        <li>
          <a href="reser.php">
            <i class="bx bx-message"></i>
            <span class="links_name">Reservations</span>
          </a>
        </li>
        <!-- Updated "Events" Section with New Icon -->
        <li>
          <a href="eventlist.php">
            <i class="bx bx-calendar-event"></i>
            <span class="links_name">Events</span>
          </a>
        </li>
        <li>
          <a href="displaycommande.php">
            <i class="bx bx-calendar-event"></i>
            <span class="links_name">order list</span>
          </a>
        </li>
      </ul>
    </div>

  <!-- Main Section -->
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
    </nav>
    <div class="home-content">
      <h1>Order List</h1>
      <input type="text" id="searchbar" placeholder="Search orders..." onkeyup="searchCart()">
      <table border="1" width="100%">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Order Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $row): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['idcommande']); ?></td>
                <td><?php echo htmlspecialchars($row['iduser']); ?></td>
                <td><?php echo htmlspecialchars($row['totalprice']); ?> TND</td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                <th>
                  <form action="approveorder.php" method="POST">
                    <input type="hidden" name="idcommande" value="<?php echo htmlspecialchars($row['idcommande']); ?>">
                    <button type="submit" id="approve">Approve</button>
                  </form>
                </th>
                <th>  
                  <form action="deleteorder.php" method="POST">
                    <input type="hidden" name="idcommande" value="<?php echo htmlspecialchars($row['idcommande']); ?>">
                    <button type="submit" id="remove">Remove</button>
                  </form>
                </th>
              </tr>

            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No orders found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
  <script src="commande.js"></script>
</body>
</html>
<?php
// Close the connection
$conn = null;
?>
