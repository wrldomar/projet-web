
<?php

//use Model\User;
//include "../model/user.php";
include "../controller/UserController.php";

$userController = new UserController();

// Récupérer la liste de tous les utilisateurs
$list = $userController->getAllUsers();

echo "<table border='1'>
<h2>Client Users</h2>
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
    
    if ($row->getType() === 'client') { 
        
        $id = $row->getId();
        $nom = $row->getNom();
        $prenom = $row->getPrenom();
        $dateNaissance = $row->getDateNaissance();
        $type = $row->getType();
        $email = $row->getEmail();
        $telephone = $row->getTelephone();

        // Afficher les informations dans une ligne du tableau
        echo "<tr>
                <td>$id</td>
                <td>$nom</td>
                <td>$prenom</td>
                <td>$dateNaissance</td> 
                <td>$type</td> 
                <td>$email</td>
                <td>$telephone</td>
              </tr>";
    }
}
echo "</table>";

echo"<br></br>";

echo "<table border='1'>
<h2>Farmer Users</h2>
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
    
    if ($row->getType() === 'fermier') { 
        
        $id = $row->getId();
        $nom = $row->getNom();
        $prenom = $row->getPrenom();
        $dateNaissance = $row->getDateNaissance();
        $type = $row->getType();
        $email = $row->getEmail();
        $telephone = $row->getTelephone();

        // Afficher les informations dans une ligne du tableau
        echo "<tr>
                <td>$id</td>
                <td>$nom</td>
                <td>$prenom</td>
                <td>$dateNaissance</td> 
                <td>$type</td> 
                <td>$email</td>
                <td>$telephone</td>
              </tr>";
    }
}
echo "</table>";

?>
