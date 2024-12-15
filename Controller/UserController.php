<?php

// Include the necessary files for the model and configuration
include (__DIR__ . '/../model/user.php');
include (__DIR__ . '/../config.php');

class UserController {

    // Function to create a new user in the database
    public function createUser($nom, $prenom, $type, $email, $telephone, $pass, $conf) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "INSERT INTO users (nom, prenom, type, email, telephone, pass, conf) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$nom, $prenom, $type, $email, $telephone, $pass, $conf]);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        }
    }

    // Function to retrieve all users from the database
    public function getAllUsers() {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "SELECT * FROM users";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
        return [];
    }

    // Function to update a user based on their ID
    public function updateUser($id, $nom, $prenom, $dateNaissance, $type, $email, $telephone) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "UPDATE users SET nom = ?, prenom = ?, type = ?, email = ?, telephone = ? WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$nom, $prenom, $type, $email, $telephone, $id]);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
        }
    }

    // Function to delete a user based on their ID
    public function deleteUser($id) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "DELETE FROM users WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$id]);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
        }
    }

    // Function to handle the registration form
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            try {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $type = $_POST['type'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $pass = $_POST['pass']; // Get the pass field
                $conf = $_POST['conf']; // Get the conf field

                // Add the user to the database
                $this->createUser($nom, $prenom, $type, $email, $telephone, $pass, $conf);
            } catch (PDOException $e) {
                die("Erreur lors du traitement de la requête : " . $e->getMessage());
            }
        }
    }

    // Function to retrieve a user by their ID
    public function getUserById($id) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "SELECT * FROM users WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
        return null;
    }

    // Function to retrieve a user by their email and password
    public function getUserByEmail($email, $pass) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "SELECT * FROM users WHERE email = ? AND pass = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$email, $pass]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
        return null;
    }

    // Function to count the number of users
    public function getUserCount() {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "SELECT COUNT(*) FROM users"; 
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_NUM);
                return $result[0];
            }
        } catch (PDOException $e) {
            die("Erreur lors du comptage des utilisateurs : " . $e->getMessage());
        }
        return 0;
    }

    // Function to update the password and confirmation of a user by their ID
    public function updateUserPassword($id, $pass, $conf) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "UPDATE users SET pass = ?, conf = ? WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$pass, $conf, $id]);
            }
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour du mot de passe de l'utilisateur : " . $e->getMessage());
        }
    }

    // Function to retrieve users by their type
    public function getUsersByType($type) {
        try {
            $db = Config::getConnexion(); // Get the database connection
            if ($db) {
                $sql = "SELECT * FROM users WHERE type = ?";
                $stmt = $db->prepare($sql);
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
