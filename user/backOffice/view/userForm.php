<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-form</title>
    <link rel="stylesheet" href="user.css">
    <script src="validate.js"></script>
    <style>
        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php
    //le fichier UserController.php pour pouvoir utiliser la classe
    include '../controller/UserController.php';

    $userController = new UserController();

    // la méthode handleRequest pour gérer le formulaire si nécessaire
    $userController->handleRequest();

    ?>
    
    <div class="form-container">
        <h2>Registration Form</h2>
        <form action="" method="POST" onsubmit="return validate()">
            <label for="id">ID</label>
            <input type="text" id="id" name="id">

            <label for="nom">Name</label>
            <input type="text" id="nom" name="nom">

            <label for="prenom">Last Name</label>
            <input type="text" id="prenom" name="prenom">

            <label for="dateNaissance">Date of Birth</label>
            <input type="date" id="dateNaissance" name="dateNaissance">

            <div class="radio-group">
                <label>Type</label>
                <label>
                    <input type="radio" id="r1" name="type" value="fermier"> Fermier
                </label>
                <label>
                    <input type="radio" id="r2" name="type" value="client"> Client
                </label>
            </div>

            <label for="email">Email</label>
            <input type="text" id="email" name="email">

            <label for="telephone">Phone</label>
            <input type="tel" id="telephone" name="telephone">

            <button type="submit" name="register">Register</button>
        </form>
        <?php 
        // Afficher un message de succès si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            echo "<div class='success-message'>User added succesfully!</div>";
        }
        ?>
    </div>
    
</body>
</html>
