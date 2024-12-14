
<?php

//include '../model/user.php';
//include '../config.php';

include (__DIR__ . '/../model/user.php');
include (__DIR__ . '/../config.php');
class UserController {
    // Fonction pour créer un nouvel utilisateur dans la base de données
    public function createUser( $nom, $prenom , $type, $email, $telephone, $pass, $conf) {
    try {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "INSERT INTO users ( nom, prenom , type, email, telephone, pass, conf) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([ $nom, $prenom , $type, $email, $telephone, $pass, $conf]);
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
                $sql = "UPDATE users SET nom = ?, prenom = ?, type = ?, email = ?, telephone = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nom, $prenom, $type, $email, $telephone, $id]);
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
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $type = $_POST['type'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $pass = $_POST['pass']; // Récupération du champ pass
            $conf = $_POST['conf']; // Récupération du champ conf

            // Ajouter l'utilisateur dans la base de données
            $this->createUser( $nom, $prenom, $type, $email, $telephone, $pass, $conf);
        } catch (PDOException $e) {
            die("Erreur lors du traitement de la requête : " . $e->getMessage());
        }
    }
}

 // Fonction pour récupérer un utilisateur par son ID
public function getUserById($id): mixed {
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

// Fonction pour récupérer un utilisateur par son nom et son prenom
public function getUserByEmail($email,$pass) {
    try {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "SELECT * FROM users WHERE email = ? AND pass = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $pass]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        die("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
    }
    return null;
}

// Fonction pour récupérer le nombre des utulisateurs
public function getUserCount() {
    try {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "SELECT COUNT(*) FROM users"; 
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_NUM);
            return $result[0];
        }
    } catch (PDOException $e) {
        die("Erreur lors du comptage des utilisateurs : " . $e->getMessage());
    }
    return 0;
}

// Fonction pour mettre à jour le mot de passe et la confirmation d'un utilisateur par son ID
public function updateUserPassword($id, $pass, $conf) {
    try {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "UPDATE users SET pass = ?, conf = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$pass, $conf, $id]);
        }
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du mot de passe de l'utilisateur : " . $e->getMessage());
    }
}

// Fonction pour récupérer un utilisateur par son type
public function getUsersByType($type) {
    try {
        $conn = Config::getConnection();
        if ($conn) {
            $sql = "SELECT * FROM users WHERE type = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$type]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des utilisateurs par type : " . $e->getMessage());
    }
    return [];
}

}



?>
