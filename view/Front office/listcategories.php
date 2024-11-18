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
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Categories List</h1>
    <table>
        <thead>
            <tr>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $category): ?>
            <tr>
                <td>
                    <a href="afficheproducts.php?id_categorie=<?php echo htmlspecialchars($category['id_categorie']); ?>" 
                       title="View products in <?php echo htmlspecialchars($category['categorie_name']); ?>">
                        <?php echo htmlspecialchars($category['categorie_name']); ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
