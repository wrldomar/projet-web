<?php
// Use the correct credentials for your MySQL database
$servername = 'localhost';
$username = 'root';  // Use the correct username, typically 'root' for XAMPP
$password = '';  // Use the correct password, '' if no password is set
$dbname = 'products';  // Ensure this matches your database name

// Create the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete comment logic
if (isset($_GET['id_comment'])) {  // Use 'id_comment' based on your table structure
    $commentId = $_GET['id_comment'];
    $sql = "DELETE FROM product_comments WHERE id_comment = ?";  // Use 'id_comment' here as well
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $commentId);
    $stmt->execute();
    header("Location: infoProduct.php"); // Redirect to 'infoProduct.php' after deletion
    exit(); // Don't forget to call exit after header redirection
}

// Fetch comments from the database
$sql = "SELECT * FROM product_comments"; // Make sure this matches your table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments Management</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Sidebar and home section remain untouched */
        /* Your existing sidebar and home-section code */

        /* Table styling for displaying comments */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }

        /* Header Styling */
        th {
            background-color: #4caf50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Row Styling */
        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Image Styling */
        td img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
        }

        /* Action Links Styling */
        td a {
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        td a:hover {
            background-color: #4caf50;
            color: white;
        }

        /* Main content styling */
        .comments-table {
            margin-left: 250px;
            padding: 30px;
        }

        .comments-table .table-title {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <!-- Sidebar remains unchanged -->
    <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-google'></i>
      <a href="../../../../home/view/front office/home.html" class="logo-link">
      <span class="logo_name">GreenHarvest</span>
      </a>
    </div>
    <ul class="nav-links">
      <li>
        <a href="#" class="nav-link" id="product-link">
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
    <!-- Main Content -->
    <div class="home-section">
        <div class="comments-table">
            <h1 class="table-title">Comment Section</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_comment']; ?></td> <!-- Use 'id_comment' here -->
                            <td><?php echo $row['user_name']; ?></td> <!-- Use 'user_name' here -->
                            <td><?php echo $row['comment']; ?></td>
                            <td>
                                <a href="comments.php?id_comment=<?php echo $row['id_comment']; ?>" class="delete-btn">Delete</a> <!-- Correct link to 'comments.php' -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
