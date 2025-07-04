
<?php

//include "../controller/UserController.php";

include '../../controller/UserController.php';

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
    .search-bar {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        margin-left: 70px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        color: #555;
    }
    .user-count-message {
        text-align: center;
        font-size: 20px;
        color: #4CAF50;
        font-weight: bold;
        margin-top: 10px;
        margin-right: 500px;
    }

    /* Style pour le bouton Return to Home */
    .return-home-container {
        text-align: center;
        margin-top: 30px;
    }

    .return-home-btn {
        background-color: #4CAF50; /* Couleur verte */
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .return-home-btn:hover {
        background-color: #45a049; /* Légère variation de couleur au survol */
        transform: scale(1.05); /* Effet de zoom au survol */
    }

    /* Styles responsive */
    @media (max-width: 600px) {
        .return-home-btn {
            width: 100%; /* Largeur complète sur les petits écrans */
            padding: 12px 0; /* Ajuster les marges et la taille du texte */
        }
    }
</style>
";

echo "
<input type='text' id='searchInput' class='search-bar' placeholder='Search by Name, Last Name, or Email' onkeyup='filterTable()'>";

$userController = new UserController();
$userCount = $userController->getUserCount();
echo "
<p class='user-count-message'>
    Total Number of Users : " . $userCount . "
</p>";

// Script JavaScript pour filtrer les données
echo "
<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toLowerCase();
        table = document.getElementsByTagName('table')[0];
        tr = table.getElementsByTagName('tr'); 
        
        for (i = 1; i < tr.length; i++) { // Commence à 1 pour ignorer l'en-tête
            td = tr[i].getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
            }

            if (found) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
</script>";

echo"<br></br>";
echo "<h2>Clients</h2>";
echo "<table >
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Type</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>";

foreach ($list as $row) {
    if ($row['type'] === 'client') {
        echo "<tr>
                <td>{$row['iduser']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['type']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telephone']}</td>
                <td>
                    <form method='post' action='edit.php' style='display:inline;'>
                        <input type='hidden'  name='iduser' value='{$row['iduser']}'>
                        <button type='submit'>Edit</button>
                    </form>
                    <form method='post' action='delete.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['iduser']}'>
                        <button type='submit' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
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
            <th>Type</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>";

foreach ($list as $row) {
    if ($row['type'] === 'farmer') {
        echo "<tr>
                <td>{$row['iduser']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['prenom']}</td>
                <td>{$row['type']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telephone']}</td>
               <td>
                    <form method='post' action='edit.php' style='display:inline;'>
                        <input type='hidden'  name='id' value='{$row['iduser']}'>
                        <button type='submit'>Edit</button>
                    </form>
                    <form method='post' action='delete.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['iduser']}'>
                        <button type='submit' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
}
echo "</table>";

echo "
<!-- Bouton Return to Home -->
<div class='return-home-container'>
    <a href='../frontoff/home.html'>
        <button class='return-home-btn'>Return to Home</button>
    </a>
</div>
";

?>
