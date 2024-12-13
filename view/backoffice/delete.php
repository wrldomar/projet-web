
<?php
include "../../controller/UserController.php";
$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $userController->deleteUser($id);
    header("Location: list.php"); 
    exit();
}
?>
