
<?php
require_once 'config.php';
require_once 'model/user.php';

class UserController {

    // Fonction pour créer un nouvel utilisateur dans la base de données
    public function createUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone) {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "INSERT INTO users (id, nom, prenom, dateNaissance, type, email, telephone) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id, $nom, $prenom, $dateNaissance, $type, $email, $telephone]);
        }
    }

    // Fonction pour récupérer tous les utilisateurs de la base de données
    public function getAllUsers() {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "SELECT * FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
        }
        return [];
    }


    // Fonction pour mettre à jour un utilisateur selon son ID
    public function updateUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone) {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "UPDATE users SET nom = ?, prenom = ?, dateNaissance = ?, type = ?, email = ?, telephone = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nom, $prenom, $dateNaissance, $type, $email, $telephone, $id]);
        }
    }

    // Fonction pour supprimer un utilisateur en fonction de son ID
    public function deleteUser($id) {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
           
            $stmt->execute([$id]);
        }
    }

    // Fonction pour traiter le formulaire d'inscription
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
            // Récupérer les données du formulaire
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $dateNaissance = $_POST['dateNaissance'];
            $type = $_POST['type'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
    
            // Ajouter l'utilisateur dans la base de données
            $this->createUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone);
    
            // Rediriger vers le formulaire avec un message de succès
            header('Location: ../view/userForm.php?success_message=User successfully registered!');
            exit();
        }
    }
}


?>
