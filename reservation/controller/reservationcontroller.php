<?php

include(__DIR__ . '/../config.php');
include(__DIR__ .'/../model/Reservation.php');

class ReservationController
{
    // Method to create a reservation
    function addReservation($reservation)
    {
        $sql = "INSERT INTO reservations 
                (id_event, name, last_name, email, phone_number, nbr_tickets, price) 
                VALUES (:id_event, :name, :last_name, :email, :phone_number, :nbr_tickets, :price)";

        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_event' => $reservation->getIdEvent(),
                'name' => $reservation->getName(),
                'last_name' => $reservation->getLastName(),
                'email' => $reservation->getEmail(),
                'phone_number' => $reservation->getPhoneNumber(),
                'nbr_tickets' => $reservation->getNbrTickets(),
                'price' => $reservation->getPrice() // Assuming the price is already set
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

}
?>