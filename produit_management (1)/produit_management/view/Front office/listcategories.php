<?php
    include '../../config.php';
    include '../../controller/categoriescontroller.php';
    $categoriescontroller = new CategoriesController();
    $list = $categoriescontroller->listcategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories List</title>
    <link rel="stylesheet" href="liste.css"> <!-- Link to your CSS -->
</head>
<body class="fade-in">

    <!-- Header Section from file 1 -->
    <header id="header">
        <div class="header-content">
            <div class="left-content">
                <a href="../dashboard/dashboard.html" class="logo-link">
                    <img src="Group 6.png" alt="Group 6 Logo" class="logo-img">
                </a>
                <a href="../../../../home/view/front office/home.html" class="link">Home</a>
                <a href="../Shop/shop1.html" class="link">Shop</a>
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
                        <img src="Group 8.png" alt="Group 8 Logo" class="logo-img">
                    </a>
                    <div class="dropdown-menu">
                        <a href="../user/signup.html" class="dropdown-link">Sign Up</a>
                        <a href="../user/login.html" class="dropdown-link">Log In</a>
                    </div>
                </div>
                <a href="../panier/index.html" class="logo-link">
                    <img src="Group 7.png" alt="Group 7 Logo" class="logo-img">
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Section -->
    <main>
        <h2 class="title">Categories List</h2>
        <p class="description">Here are the available categories for browsing and shopping.</p>

        <div class="overlay-container">

        <?php foreach ($list as $category): ?>
            <div class="category-overlay <?php echo strtolower($category['categorie_name']); ?>">

                <!-- Make the category name clickable -->
                <a href="afficheproducts.php?id_categorie=<?php echo htmlspecialchars($category['id_categorie']); ?>" 
                   title="View products in <?php echo htmlspecialchars($category['categorie_name']); ?>" class="category-link">
                    <h2><?php echo htmlspecialchars($category['categorie_name']); ?></h2>
                </a>

                <!-- Dynamically load images for each category -->
                <?php if ($category['categorie_name'] == 'Fruits'): ?>
                    <img src="fruits.png" alt="Fruits" class="overlay-image">
                <?php elseif ($category['categorie_name'] == 'Seeds'): ?>
                    <img src="seed.png" alt="Seeds" class="overlay-image">
                <?php elseif ($category['categorie_name'] == 'Vegetables'): ?>
                    <img src="vegetables.png" alt="Vegetables" class="overlay-image">
                <?php else: ?>
                    <!-- Default category image if no specific category image is provided -->
                    <img src="default-category-image.png" alt="Default Image" class="overlay-image">
                <?php endif; ?>

                <p>Discover our fresh, seasonal <?php echo htmlspecialchars($category['categorie_name']); ?>, handpicked for maximum flavor and nutrition. Perfect for enhancing any meal, these vibrant items bring a burst of color and health to your table.</p>
            </div>
        <?php endforeach; ?>

        </div>
    </main>

    <!-- JavaScript -->
    <script>
        // Fade-in effect on page load
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });

        // Header scroll hide effect
        let lastScrollY = window.scrollY;
        const header = document.querySelector("header");

        window.addEventListener("scroll", () => {
            if (window.scrollY > lastScrollY) {
                header.style.transform = "translateY(-100%)"; // Hide the header
            } else {
                header.style.transform = "translateY(0)"; // Show the header
            }
            lastScrollY = window.scrollY;
        });
    </script>

</body>
</html>
