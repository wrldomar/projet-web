<?php
include '../../config.php';
include '../../controller/categoriescontroller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie_name = trim($_POST['categorie_name']);
    $categorie_image = null;

    // Define the correct upload directory in front office
    $uploadDir = '../../../../home/view/front office/uploads/'; // Adjust the path to your front office uploads folder

    // Ensure the uploads directory exists in the front office
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }

    // Handle the image upload
    if (isset($_FILES['categorie_image']) && $_FILES['categorie_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['categorie_image']['tmp_name'];
        $imageName = uniqid() . '_' . basename($_FILES['categorie_image']['name']);
        $imagePath = $uploadDir . $imageName;

        // Move the uploaded file to the front office uploads directory
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $categorie_image = 'uploads/' . $imageName;  // Store the relative path to the image
        }
    }

    // Insert category into the database
    $sql = "INSERT INTO categories (categorie_name, categorie_image) VALUES (:categorie_name, :categorie_image)";
    $db = config::getConnexion();
    $query = $db->prepare($sql);
    $query->execute([
        'categorie_name' => $categorie_name,
        'categorie_image' => $categorie_image
    ]);

    header('Location: listCategorie.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styling */
        body {
            display: flex;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #4caf50;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        .logo-details {
            display: flex;
            align-items: center;
        }

        .logo-name {
            font-size: 22px;
            margin-left: 10px;
        }

        .nav-links {
            list-style-type: none;
            padding: 0;
            margin-top: 40px;
        }

        .nav-links li {
            margin-bottom: 20px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .nav-links i {
            font-size: 20px;
            margin-right: 10px;
        }

        .nav-links .active {
            background-color: #3e8e41;
        }

        .home-section {
            flex: 1;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        .search-box input {
            padding: 8px;
            font-size: 14px;
        }

        .search-box {
            margin-left: auto;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-google'></i>
            <a href="../../../../home/view/front office/home.html" class="logo-link">
                <span class="logo_name">GreenHarvest</span>
            </a>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#" class="active">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="listCategorie.php">
                    <i class='bx bx-category'></i>
                    <span class="links_name">Categories</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <section class="home-section">
        <h1>Add Category</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categorie_name">Category Name:</label>
                <input type="text" name="categorie_name" id="categorie_name" required>
            </div>
            <div class="form-group">
                <label for="categorie_image">Category Image:</label>
                <input type="file" name="categorie_image" id="categorie_image" accept="image/*">
            </div>
            <button type="submit">Add Category</button>
        </form>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll(".nav-links a");

            navLinks.forEach(link => {
                link.addEventListener("click", function () {
                    navLinks.forEach(link => link.classList.remove("active"));
                    this.classList.add("active");
                });
            });
        });
    </script>
</body>
</html>
