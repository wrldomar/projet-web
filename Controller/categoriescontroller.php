<?php


    include(__DIR__ . '../../model/categories.php');

    class CategoriesController
    {
        
        // Method to print all reservations
        public function listcategories()
        {
            $sql = "SELECT id_categorie,categorie_name FROM categories";
            $db = config::getConnexion();
            try {
                $liste = $db->query($sql);
                return $liste;
            } catch (Exception $e) {
                die('Error:' . $e->getMessage());
            }
        }


    }
?>
