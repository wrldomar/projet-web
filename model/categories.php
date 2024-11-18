<?php
class Categories {
    private $id_categorie;
    private $categorie_name;

    // Constructor
    public function __construct($id_categorie = null, $categorie_name = null) {
        $this->id_categorie = $id_categorie;
        $this->categorie_name = $categorie_name;
    }

    // Getters and Setters
    public function getIdCategorie() {
        return $this->id_categorie;
    }

    public function setIdCategorie($id_categorie) {
        $this->id_categorie = $id_categorie;
    }

    public function getCategorieName() {
        return $this->categorie_name;
    }

    public function setCategorieName($categorie_name) {
        $this->categorie_name = $categorie_name;
    }
}
?>
