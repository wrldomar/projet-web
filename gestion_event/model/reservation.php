<?php

class Reservation
{
    private $id_reservation;
    private $id_event;
    private $name;
    private $last_name;
    private $email;
    private $phone_number;
    private $nbr_tickets;
    private $price;

    // Constructor
    public function __construct($id_reservation,
    $id_event,$name,$last_name,$email,
    $phone_number,$nbr_tickets,$price)
    {
        $this->id_reservation=$id_reservation;
        $this->id_event=$id_event;
        $this->name=$name;
        $this->last_name=$last_name;
        $this->email=$email;
        $this->phone_number=$phone_number;
        $this->nbr_tickets=$nbr_tickets;
        $this->price=$price;
    }

    // Getter and Setter methods for each attribute

    public function getIdReservation() 
    { return $this->id_reservation; }
    
    public function setIdReservation($id_reservation)
     { $this->id_reservation = $id_reservation; }

    public function getIdEvent() { return $this->id_event; }
    public function setIdEvent($id_event) { $this->id_event = $id_event; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getLastName() { return $this->last_name; }
    public function setLastName($last_name) { $this->last_name = $last_name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPhoneNumber() { return $this->phone_number; }
    public function setPhoneNumber($phone_number) { $this->phone_number = $phone_number; }

    public function getNbrTickets() { return $this->nbr_tickets; }
    public function setNbrTickets($nbr_tickets) { $this->nbr_tickets = $nbr_tickets; }

    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }


}
?>