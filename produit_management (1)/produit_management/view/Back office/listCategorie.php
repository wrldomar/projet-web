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
      <i class='bx bxl-google'></i>
      <a href="../../../../home/view/front office/home.html" class="logo-link">
      <span class="logo_name">GreenHarvest</span>
      </a>
    </div>
    <ul class="nav-links">
      <li>
        <a href="./listproduct.php" class="nav-link" id="product-link">
          <i class='bx bx-box'></i>
          <span class="links_name">Product</span>
        </a>
      </li>

      <!-- Categories Link -->
      <li>
        <a href="listCategorie.php">
          <i class='bx bx-category'></i>
          <span class="links_name">Categories</span>
        </a>
      </li>

      <!-- Comments Link -->
      <li>
        <a href="comments.php" class="nav-link" id="comments-link">
          <i class='bx bx-message'></i>
          <span class="links_name">Comments</span>
        </a>
      </li>
    </ul>
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
