<?php

class Panier {
    // Propriétés
    private $idpa;
    private $prixtotal;
    private $quantitepanier;

    // Instance unique de la classe (singleton)
    private static $instance = null;

    // Constructeur privé pour empêcher l'instanciation externe
    private function __construct($idpa = 0, $prixtotal = 0.0, $quantitepanier = 0) {
        $this->idpa = $idpa;
        $this->prixtotal = $prixtotal;
        $this->quantitepanier = $quantitepanier;
    }

    // Méthode pour obtenir l'instance unique de la classe
    public static function getInstance($idpa = 0, $prixtotal = 0.0, $quantitepanier = 0) {
        if (self::$instance === null) {
            self::$instance = new Panier($idpa, $prixtotal, $quantitepanier);
        }
        return self::$instance;
    }

    // Getters
    public function getIdpa() {
        return $this->idpa;
    }

    public function getPrixTotal() {
        return $this->prixtotal;
    }

    public function getQuantitePanier() {
        return $this->quantitepanier;
    }

    // Setters
    public function setIdpa($idpa) {
        $this->idpa = $idpa;
    }

    public function setPrixTotal($prixtotal) {
        $this->prixtotal = $prixtotal;
    }

    public function setQuantitePanier($quantitepanier) {
        $this->quantitepanier = $quantitepanier;
    }

    // Méthodes
    public function ajouterQuantite($quantite) {
        $this->quantitepanier += $quantite;
    }

    public function calculerPrixTotal($prixUnitaire) {
        $this->prixtotal = $this->quantitepanier * $prixUnitaire;
    }
}

?>
