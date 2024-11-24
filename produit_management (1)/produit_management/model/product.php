<?php
class Product {
    private $id_product;
    private $id_farmer;
    private $id_categorie;
    private $name_product;
    private $product_price;
    private $quantite;
    private $product_image;

    // Constructor
    public function __construct($id_product = null, $id_farmer = null, $id_categorie = null, $name_product = null, $product_price = null, $quantite = null) {
        $this->id_product = $id_product;
        $this->id_farmer = $id_farmer;
        $this->id_categorie = $id_categorie;
        $this->name_product = $name_product;
        $this->product_price = $product_price;
        $this->quantite = $quantite;
    }

    // Getters and Setters
    public function getIdProduct() {
        return $this->id_product;
    }

    public function setIdProduct($id_product) {
        $this->id_product = $id_product;
    }

    public function getIdFarmer() {
        return $this->id_farmer;
    }

    public function setIdFarmer($id_farmer) {
        $this->id_farmer = $id_farmer;
    }

    public function getIdCategorie() {
        return $this->id_categorie;
    }

    public function setIdCategorie($id_categorie) {
        $this->id_categorie = $id_categorie;
    }

    public function getNameProduct() {
        return $this->name_product;
    }

    public function setNameProduct($name_product) {
        $this->name_product = $name_product;
    }

    public function getProductPrice() {
        return $this->product_price;
    }

    public function setProductPrice($product_price) {
        $this->product_price = $product_price;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
    }
    public function getProductImage() {
        return $this->product_image;
    }
    
    public function setProductImage($product_image) {
        $this->product_image = $product_image;
    }
}
?>
