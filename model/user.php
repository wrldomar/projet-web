<?php
//namespace Model;
class User{

    private $id;
    private $nom;
    private $prenom;
    private $type;
    private $email;
    private $telephone;
    private $pass; // Ajout de l'attribut pass
    private $conf; // Ajout de l'attribut conf

    public function __construct($id = null, $nom = null, $prenom = null, $type = null, $email = null, $telephone = null, $pass = null, $conf = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->type = $type;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->pass = $pass; // Initialisation de pass
        $this->conf = $conf; // Initialisation de conf
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

    public function getPass()
    {
        return $this->pass;
    }

    public function getConf()
    {
        return $this->conf;
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

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function setConf($conf)
    {
        $this->conf = $conf;
    }

}
?>
