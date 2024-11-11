<?php

class user{

    private $id;
    private $nom;
    private $prenom;
    private $dateNaissance;
    private $type;
    private $email;
    private $telephone;
    
    public function __construct($id,$nom,$prenom,$dateNaissance,$type,$email,$telephone)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->type = $type;
        $this->email = $email;
        $this->telephone = $telephone;
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getEmail()
    {
        return  $this->email;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

}






















?>