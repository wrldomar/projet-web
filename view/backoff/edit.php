
<?php
include "../../controller/UserController.php";
$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    // Récupérer les données de l'utilisateur
    $user = $userController->getUserById($id);

    if ($user) {
        echo "
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f7fc;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .form-container {
                background-color: white;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
            }
            h2 {
                text-align: center;
                color: #333;
            }
            label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
                color: #555;
            }
            input[type='text'], input[type='email'], input[type='tel'], input[type='date'] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }
            button[type='submit'] {
                width: 100%;
                padding: 15px;
                background-color: #4CAF50;
                color: white;
                font-size: 18px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            button[type='submit']:hover {
                background-color: #45a049;
            }
        </style>
        <div class='form-container'>
            <h2>Update User</h2>
            <form method='post' action='update.php'>
                <input type='hidden' name='id' value='{$user['id']}'>
                <label>Name:</label>
                <input type='text' name='nom' value='{$user['nom']}'>
                <label>Last Name:</label>
                <input type='text' name='prenom' value='{$user['prenom']}'>
                <label>Type:</label>
                <input type='text' name='type' value='{$user['type']}'>
                <label>Email:</label>
                <input type='email' name='email' value='{$user['email']}'>
                <label>Phone:</label>
                <input type='text' name='telephone' value='{$user['telephone']}'>
                <button type='submit' name='update'>Update</button>
            </form>
            
        </div>";
    }
}
?>
