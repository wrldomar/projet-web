<?php
class Product {
    private $idproduit;
    private $category;
    private $price;
    private $quantite;

    public function __construct($idp, $category, $price, $quantite) {
        $this->id = $idp;
        $this->category = $category; 
        $this->price = $price;
        $this->stock = $quantite;
    }

    public function setId($idp) {
        $this->idproduit = $idp;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setStock($quantite) {
        $this->quantite = $quantite;
    }


    

    public function getId() {
        return $this->id;
    }

    public function getCategory() {
        return $this->category;
    }
   
    public function getPrice() {
        return $this->price;
    }

    public function quantite() {
        return $this->quantite;
    }
}

?>