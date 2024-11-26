
<?php

// Inclure le contrôleur
include $_SERVER['DOCUMENT_ROOT'] . '/projet-web/BackOffice/controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['firstName'];
    $nom = $_POST['lastName'];

    // Instancier le contrôleur utilisateur
    $userController = new UserController();

    // Récupérer l'utilisateur
    $user = $userController->getUserByName($nom, $prenom);

    if ($user) {
        // Si l'utilisateur existe, afficher un message de bienvenue
        echo "Welcome, " . htmlspecialchars($user['nom']) . " " . htmlspecialchars($user['prenom']) . "!";
    } 
    else {
        // Redirection sécurisée vers le formulaire utilisateur
        header("Location: /projet-web/BackOffice/view/userForm.php");
        exit();
    }
}
?>
