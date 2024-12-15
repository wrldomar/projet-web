<?php
class Reponse
{
    private ?int $id_rep = null;
    private ?int $idrec ;
    private ?string $reponse;
    private ?DateTime $date_reponse;
   

    public function __construct($id_rep = null, $idrec, $reponse, $date_reponse)
    {
        $this->id_rep = $id_rep;
        $this->idrec = $idrec;
        $this->reponse = $reponse;
        $this->date_reponse = $date_reponse;
    }

    public function getid_rep()
    {
        return $this->id_rep;
    }
    public function getidrec()
    {
        return $this->idrec;
    }
    public function getreponse()
    {
        return $this->reponse;
    }
    public function getdate_rep()
    {
        return $this->date_reponse;
    }
    public function setid_rep($id_rep)
    {
        $this->id_rep = $id_rep;

    }
    public function setidrec($idrec)
    {
        $this->idrec = $idrec;

        
    }
    public function setreponse($reponse)
    {
        $this->reponse= $reponse;

        
    }
    public function setdate_rep($date_reponse)
    {
        $this->date_reponse = $date_reponse;

       
    }
}