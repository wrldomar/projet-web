
<?php

//include "../controller/UserController.php";

include 'C:/xampV.2/htdocs/projet-web/BackOffice/controller/UserController.php';

$userController = new UserController();

// Récupérer la liste de tous les utilisateurs
$list = $userController->getAllUsers();

// Styles CSS
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
    /* Styles pour les boutons */
    button {
        border: none;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    button:hover {
        transform: scale(1.05);
    }
    button[type='submit']:not(.delete) {
        background-color: #007BFF;
        color: white;
    }
    button[type='submit']:not(.delete):hover {
        background-color: #0056b3;
    }
    button.delete {
        background-color: #FF4D4D;
        color: white;
    }
    button.delete:hover {
        background-color: #cc0000;
    }
</style>
";

echo "<h2>Clients</h2>";
echo "<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Type</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
            <th>Account Status</th>
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
                <td>
                    <form method='post' action='edit.php' style='display:inline;'>
                        <input type='hidden'  name='id' value='{$row['id']}'>
                        <button type='submit'>Edit</button>
                    </form>
                    <form method='post' action='delete.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
                    </form>
                </td>
                <td>
                <form  action='mail.php' style='display:inline;'>
                    <button type='submit'>Activate</button>
                </form>
                </td>
              </tr>";
    }
}
echo "</table>";

echo"<br></br>";

echo "<h2>Farmers</h2>";
echo "<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Type</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
             <th>Account Status</th>
        </tr>";

foreach ($list as $row) {
    if ($row['type'] === 'farmer') {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['dateNaissance']}</td>
                <td>{$row['type']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telephone']}</td>
               <td>
                    <form method='post' action='edit.php' style='display:inline;'>
                        <input type='hidden'  name='id' value='{$row['id']}'>
                        <button type='submit'>Edit</button>
                    </form>
                    <form method='post' action='delete.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
                    </form>
                </td>
                <td>
                <form action='mail.php' style='display:inline;'>
                    <button type='submit'>Activate</button>
                </form>
                </td>
              </tr>";
    }
}
echo "</table>";
?>
