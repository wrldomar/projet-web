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
 /* Add Category Section */
.home-section .add-category {
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 600px;
}

.add-category h1 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #4caf50;
    font-weight: 600;
    border-bottom: 2px solid #4caf50;
    padding-bottom: 10px;
}

/* Form Styling */
.add-category form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.add-category .form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.add-category label {
    font-size: 16px;
    color: #333;
    font-weight: 500;
}

.add-category input[type="text"],
.add-category input[type="file"] {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 6px;
    transition: border-color 0.3s ease;
}

.add-category input[type="text"]:focus,
.add-category input[type="file"]:focus {
    border-color: #4caf50;
    outline: none;
    box-shadow: 0 0 4px rgba(76, 175, 80, 0.4);
}

/* Button Styling */
.add-category button {
    background-color: #4caf50;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.add-category button:hover {
    background-color: #45a049;
    transform: scale(1.02);
}

/* Responsive Design for Add Category */
@media (max-width: 768px) {
    .add-category {
        margin: 10px;
        padding: 15px;
    }

    .add-category button {
        font-size: 14px;
        padding: 10px;
    }
}


.error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}


    </style>

</head>
<body>
    <!-- Sidebar -->
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

    <!-- Main Content Area -->
    <section class="home-section">
    <div class="add-category">
        <h1>Add Category</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categorie_name">Category Name:</label>
                <input type="text" name="categorie_name" id="categorie_name" >
            </div>
            <div class="form-group">
                <label for="categorie_image">Category Image:</label>
                <input type="file" name="categorie_image" id="categorie_image" accept="image/*">
            </div>
            <button type="submit">Add Category</button>
        </form>
    </div>
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






        document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector("form");
        const categoryNameInput = document.querySelector("#categorie_name");
        const categoryImageInput = document.querySelector("#categorie_image");
        const submitButton = form.querySelector("button");

        // Create error message containers
        const categoryNameError = document.createElement("div");
        categoryNameError.className = "error-message";
        categoryNameInput.parentElement.appendChild(categoryNameError);

        const categoryImageError = document.createElement("div");
        categoryImageError.className = "error-message";
        categoryImageInput.parentElement.appendChild(categoryImageError);

        // Image Preview
        const imagePreview = document.createElement("img");
        imagePreview.style.display = "none";
        imagePreview.style.marginTop = "10px";
        imagePreview.style.maxWidth = "200px";
        imagePreview.style.borderRadius = "8px";
        categoryImageInput.parentElement.appendChild(imagePreview);

        categoryImageInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    imagePreview.src = reader.result;
                    imagePreview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = "none";
            }
        });

        // Form Validation
        form.addEventListener("submit", (event) => {
            let isValid = true;

            // Reset error messages
            categoryNameError.textContent = "";
            categoryImageError.textContent = "";

            if (!categoryNameInput.value.trim()) {
                categoryNameError.textContent = "Category name is required.";
                isValid = false;
            }

            if (!categoryImageInput.files.length) {
                categoryImageError.textContent = "Please select a category image.";
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission
            }
        });
    });

    </script>
</body>
</html>
