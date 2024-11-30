<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Sign In</title>
  <link rel="stylesheet" href="login.css">
  <script src="valider.js"></script>
  <style>
        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
  <div class="login-container">
    <h2>Sign In</h2>
    <form action="" method="post" onsubmit="return valider()">
      <input type="text" placeholder="First Name" name="firstName" id="n1">
      <input type="text" placeholder="Last Name" name="lastName" id="n2">
      <br><br>
      <button type="submit">Sign In</button>
      <a href="home.html">
        <button type="button" class="logout-button">Sign Out</button>
      </a>
    </form>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/projet-web/BackOffice/controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $prenom = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';

    $userController = new UserController();
    $user = $userController->getUserByName($nom, $prenom);

    if ($user && isset($user['nom']) && isset($user['prenom'])) {

        echo "<div class='success-message'>Welcome, " . htmlspecialchars($user['nom']) . " " . htmlspecialchars($user['prenom']) . "!</div>";
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'home.html';
                }, 2000); 
              </script>";
    } 
    else {
        header("Location: /projet-web/BackOffice/view/userForm.php");
        exit();
    }
}
?>
<div class="footer">*
  <p>&copy; 2024 All Rights Reserved by GreenHarvest.</p>
</div>
</div>
</body>
</html>
