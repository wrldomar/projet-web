
<?php

include '../controller/UserController.php';

//include '../BackOffice/controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['firstName'];
    $nom = $_POST['lastName'];

    $userController = new UserController();
    $user = $userController->getUserByName($prenom, $nom);

    if ($user) {
        // si L'utilisateur existe, afficher un message de bienvenue
        echo "Welcome, " . $user['prenom'] . " " . $user['nom'] . "!";
    } 

    else {
        header("Location: ../view/userForm.php");
        exit();
    }
}
?>

