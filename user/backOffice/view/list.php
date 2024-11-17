<?php
// use Model\User;
// include "../model/user.php";
include "../controller/UserController.php";

$userController = new UserController();

// Récupérer la liste de tous les utilisateurs
$list = $userController->getAllUsers();

echo "
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f4f4f9;
    }
    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 10px;
        font-size: 24px;
    }
    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
    td {
        color: #555;
    }
</style>
";

echo "<h2>Client Users</h2>";
echo "<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Type</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>";

foreach ($list as $row) {
    if ($row['type'] === 'client') { 
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['dateNaissance']}</td> 
                <td>{$row['type']}</td> 
                <td>{$row['email']}</td>
                <td>{$row['telephone']}</td>
              </tr>";
    }
}
echo "</table>";

echo "<h2>Farmer Users</h2>";
echo "<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Type</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>";

foreach ($list as $row) {
    if ($row['type'] === 'fermier') { 
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['dateNaissance']}</td> 
                <td>{$row['type']}</td> 
                <td>{$row['email']}</td>
                <td>{$row['telephone']}</td>
              </tr>";
    }
}
echo "</table>";
?>
