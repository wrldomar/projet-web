<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-form</title>
    <script src="validate.js"></script>
    <style>
        /* General reset and body styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], 
        input[type="email"], 
        input[type="tel"], 
        input[type="date"], 
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, 
        input[type="email"]:focus, 
        input[type="tel"]:focus, 
        input[type="date"]:focus, 
        input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .radio-group {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .radio-group label {
            display: inline-block;
            margin-right: 10px;
            color: #555;
        }

        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #555;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                width: 100%;
                max-width: 90%;
            }

            input[type="text"], 
            input[type="email"], 
            input[type="tel"], 
            input[type="date"], 
            input[type="password"] {
                font-size: 14px;
                padding: 10px;
            }

            button[type="submit"] {
                font-size: 16px;
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .radio-group {
                flex-direction: column;
            }

            .radio-group label {
                margin-bottom: 10px;
            }

            button[type="submit"] {
                font-size: 14px;
                padding: 12px;
            }
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
</head>
<body>
    <?php
        include '../../controller/UserController.php';

        $userController = new UserController();
        $userController->handleRequest();
    ?>
    
    <div class="form-container">
        <h2>Registration Form</h2>
        <form action="" method="POST" onsubmit="return validate()">

            <label for="nom">Name</label>
            <input type="text" id="nom" name="nom" placeholder="Enter your name">

            <label for="prenom">Last Name</label>
            <input type="text" id="prenom" name="prenom" placeholder="Enter your last name">

            <div class="radio-group">
                <label>Type</label>
                <label>
                    <input type="radio" id="r1" name="type" value="farmer"> Farmer
                </label>
                <label>
                    <input type="radio" id="r2" name="type" value="client"> Client
                </label>
            </div>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email">

            <label for="telephone">Phone</label>
            <input type="tel" id="telephone" name="telephone" placeholder="Enter your phone number">

            <label for="pass">Create Password</label>
            <input type="password" id="pass" name="pass" placeholder="Create a password">

            <label for="conf">Confirm Password</label>
            <input type="password" id="conf" name="conf" placeholder="Confirm your password">

            <button type="submit" name="register">Register</button>
        </form>
        <div class='return-home-container'>
            <a href='login.php'>
        <button class='return-home-btn'>Return to Sign in</button></a>
        </div>
        <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            echo "<div class='success-message'>User added successfully!</div>";
        }
        ?>
</body>
</html>
