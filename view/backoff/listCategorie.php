<?php
include '../../config.php';
include '../../controller/categoriescontroller.php';

$categoriesController = new CategoriesController();
$list = $categoriesController->listcategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories List</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
       table {
    width: 75%;
    border-collapse: collapse;
    margin: 0px 300px;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);  /* Adds soft shadow for depth */
    border-radius: 8px;  /* Rounds the corners for a smoother look */
}

th, td {
    padding: 12px 15px;  /* Increased padding for better spacing */
    text-align: left;
    border-bottom: 1px solid #ddd;  /* Light border between rows */
}

th {
    background-color: #4caf50;  /* Green background for header */
    color: white;  /* White text for header */
    font-weight: bold;  /* Bold header text for emphasis */
    text-transform: uppercase;  /* Capitalizes header text */
    letter-spacing: 1px;  /* Adds slight spacing between letters */
}

tr:nth-child(even) {
    background-color: #f9f9f9;  /* Light gray for even rows */
}

tr:hover {
    background-color: #f1f1f1;  /* Light hover effect for rows */
}

/* Action Buttons Container */
.action-buttons {
    margin: 20px 300px;
    text-align: center;  /* Centers the action buttons */
}

/* Action Button Links */
.action-buttons a {
    text-decoration: none;
    padding: 12px 24px;
    color: white;
    background-color: #4caf50; /* Default for Add Category button */
    border-radius: 4px;
    margin: 10px;
    font-size: 16px;
    font-weight: bold;
    transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
}

/* "Add Category" Button Hover Effect */
.action-buttons .add-category:hover {
    background-color: #388e3c;  /* Darker green for Add Category */
    transform: scale(1.05);  /* Slightly enlarge the button */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);  /* Adds shadow on hover */
}

/* "Delete Category" Button Hover Effect */
.action-buttons .delete-category:hover {
    background-color: #d32f2f;  /* Red for Delete Category */
    transform: scale(1.05);  /* Slightly enlarge the button */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);  /* Adds shadow on hover */
}




    </style>
</head>
<body>
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
          <a href="#">
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
      </ul>
    </div>

    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
          <input type="text" placeholder="Search..." />
          <i class="bx bx-search"></i>
        </div>
      </nav>
      <br>
      <br>
      <br>
      <br>
      <br>

            </ul>
          </div>
        </div>
      </div>

    <h1>Categories</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id_categorie']); ?></td>
                    <td><?php echo htmlspecialchars($category['categorie_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="action-buttons">
    <a href="addCategorie.php" class="add-category">Add Category</a>
    <a href="deleteCategorie.php" class="delete-category">Delete Category</a>
</div>

</body>
</html>
