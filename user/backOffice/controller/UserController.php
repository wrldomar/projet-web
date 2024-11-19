
<?php
include '../model/user.php';
include '../config.php';

class UserController {

    // Fonction pour créer un nouvel utilisateur dans la base de données
    public function createUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone) {
        try {
            $conn = Config::getConnection();
            if ($conn) {
                $sql = "INSERT INTO users (id, nom, prenom, dateNaissance, type, email, telephone) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$id, $nom, $prenom, $dateNaissance, $type, $email, $telephone]);
            }
        } catch (PDOException $e) {
            // Affiche une erreur claire en cas de problème
            die("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        }
    }

    // Fonction pour récupérer tous les utilisateurs de la base de données
    public function getAllUsers() {
        try {
            $conn = Config::getConnection();
            if ($conn) {
                $sql = "SELECT * FROM users";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
        return [];
    }

    // Fonction pour mettre à jour un utilisateur selon son ID
    public function updateUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone) {
        try {
            $conn = Config::getConnection();
            if ($conn) {
                $sql = "UPDATE users SET nom = ?, prenom = ?, dateNaissance = ?, type = ?, email = ?, telephone = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nom, $prenom, $dateNaissance, $type, $email, $telephone, $id]);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
        }
    }

    // Fonction pour supprimer un utilisateur en fonction de son ID
    public function deleteUser($id) {
        try {
            $conn = Config::getConnection();
            if ($conn) {
                $sql = "DELETE FROM users WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$id]);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
        }
    }

    // Fonction pour traiter le formulaire d'inscription
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            try {
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
            } catch (PDOException $e) {
                die("Erreur lors du traitement de la requête : " . $e->getMessage());
            }
        }
    }

    // Fonction pour récupérer un utilisateur par son ID
public function getUserById($id) {
    try {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        die("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
    }
    return null;
}


}
?>
