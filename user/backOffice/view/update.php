
<?php
include "../controller/UserController.php";
$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['dateNaissance'];
    $type = $_POST['type'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    $userController->updateUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone);
    header("Location: list.php"); 
}
?>
