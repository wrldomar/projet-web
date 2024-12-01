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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4caf50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-buttons {
            margin-top: 20px;
        }
        .action-buttons a {
            text-decoration: none;
            padding: 10px 20px;
            color: white;
            background-color: #4caf50;
            border-radius: 4px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    
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
        <a href="addCategorie.php">Add Category</a>
        <a href="deleteCategorie.php">Delete Category</a>
    </div>
</body>
</html>
