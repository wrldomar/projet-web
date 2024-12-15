<?php
class Reclamation
{
    private ?int $id_rec = null;
    private ?string $sujet = null;
    private ?DateTime $date = null;
    private ?string $description = null;
   

    public function __construct($id_rec = null, $sujet, $date, $description)
    {
        $this->id_rec = $id_rec;
        $this->sujet = $sujet;
        $this->date = $date;
        $this->description = $description;
    }

    public function getid_rec()
    {
        return $this->id_rec;
    }
    public function getsujet()
    {
        return $this->sujet;
    }
    public function getdate()
    {
        return $this->date;
    }
    public function getdescription()
    {
        return $this->description;
    }
    public function setid_rec($id_rec)
    {
        $this->id_rec = $id_rec;

        return $this;
    }
    public function setsujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }
    public function setdate($date)
    {
        $this->date = $date;

        return $this;
    }
    public function setdescription($description)
    {
        $this->description = $description;

        return $this;
    }
}