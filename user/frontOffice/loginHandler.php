<?php

include $_SERVER['DOCUMENT_ROOT'] . '/projet-web/BackOffice/controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    $prenom = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $nom = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';     


    $userController = new UserController();

  
    $user = $userController->getUserByName($nom, $prenom);

    if ($user && isset($user['nom']) && isset($user['prenom'])) {
       
        echo "Welcome, " . htmlspecialchars($user['nom']) . " " . htmlspecialchars($user['prenom']) . "!";
    } 
    else {
        header("Location: /projet-web/BackOffice/view/userForm.php");
        exit();
    }
}
?>
