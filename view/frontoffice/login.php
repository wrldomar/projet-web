<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Sign In</title>
  <link rel="stylesheet" href="login.css">
  <script src="valider.js" defer></script>
  <style>
        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .error-message {
            color: red;
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
        .create-account {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .create-account:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        #email, #password {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
  <div class="login-container">
    <h2>Sign In</h2>
    <form action="" method="post" onsubmit="return valider()">
      <input type="email" placeholder="Email" name="email" id="email" required>
      <input type="password" placeholder="Password" name="password" id="password" required>
      <br><br>
      <button type="submit">Sign In</button>
    </form>
    <br>
    <a href="userForm.php" class="create-account">Create an account</a>

<?php
session_start(); // Démarrer une session PHP

if (isset($_SESSION['user'])) {
    echo "<script>
            window.location.href = 'home.html';
          </script>";
    exit;
}

include '../../controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    $userController = new UserController();
    $user = $userController->getUserByEmail($email, $password);

    if ($user && isset($user['email']) && isset($user['pass']) && isset($user['type'])) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user'] = [
            'email' => $user['email'],
            'nom' => $user['nom'] ?? 'User',
            'type' => $user['type']
        ];

        $redirectPage = 'home.html';
        if ($user['type'] === 'farmer') {
            $redirectPage = 'add_event.php';
        } elseif ($user['type'] === 'farmer') {
            $redirectPage = 'addingproduct.php';
        } elseif ($user['type'] === 'client') {
            $redirectPage = 'eventacc.php';
        }

        echo "<div class='success-message'>Welcome, {$_SESSION['user']['nom']}! Redirecting...</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '$redirectPage';
                }, 2000);
              </script>";
    } else {
        echo "<div class='error-message'>User not registered, incorrect password, or invalid user type!</div>";
    }
}
?>

<div class="footer">
  <p>&copy; 2024 All Rights Reserved by GreenHarvest.</p>
</div>
</div>
</body>
</html>
