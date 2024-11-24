<?php

// In your ReservationController.php (or any other file):
require_once '../../config.php';
require_once '../../model/reservation.php';


class ReservationController
{
    // Method to create a reservation
    function addReservation($reservation)
{
    $db = config::getConnexion();
    
    // Check if the event ID exists in the events table
    $eventCheckSql = "SELECT id_event FROM event WHERE id_event = :id_event";
    $stmt = $db->prepare($eventCheckSql);
    $stmt->execute(['id_event' => $reservation->getIdEvent()]);
    
    if ($stmt->rowCount() == 0) {
        echo "Error: Event ID not found!";
        return;
    }

    // Proceed with the reservation if event ID is valid
    $sql = "INSERT INTO reservations 
            (id_event, name, last_name, email, phone_number, nbr_tickets, price) 
            VALUES (:id_event, :name, :last_name, :email, :phone_number, :nbr_tickets, :price)";

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

public function listreservations() {
    $sql = "SELECT * FROM reservations";
    $db = config::getConnexion();
    try {
        $stmt = $db->query($sql);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Debugging: Check the structure of $reservations
        //var_dump($reservations);  // This will show all the data retrieved

        return $reservations;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


    
    function deleteOffer($id_reservation)
{
    $sql = "DELETE FROM reservations WHERE id_reservation = :id_reservation";
    $db = config::getConnexion();
    $req = $db->prepare($sql);
    $req->bindValue(':id_reservation', $id_reservation, PDO::PARAM_INT); // Ensure it's treated as an integer

    try {
        $req->execute();
        echo "Reservation deleted successfully."; // You can remove this later
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
}
    public function reservationbyid()
        {
            $sql="SELECT `id_reservation`, `id_event`, `name`, `last_name`, `email`, `phone_number`, `nbr_tickets`, `price` FROM `reservations` WHERE (id_reservation=1)";
            $db=config::getConnexion();
            try {
                $liste = $db->query($sql);
                return $liste;
            } catch (Exception $e) {
                die('Error:' . $e->getMessage());
            }
        }
    function updatereservation($reservation, $id)
        {
            try {
                $db = config::getConnexion();
                $query = $db->prepare(
                    'UPDATE reservations SET 
                        name = :name,
                        last_name = :last_name,
                        email = :email,
                        phone_number = :phone_number,
                        price=:price,
                        nbr_tickets = :nbr_tickets
                    WHERE id_reservation = :id'
                );
                $query->execute([
                    'name' => $reservation->getName(),
                    'last_name' => $reservation->getLastName(),
                    'email' => $reservation->getEmail(),
                    'phone_number' => $reservation->getPhoneNumber(),
                    'nbr_tickets' => $reservation->getNbrTickets(),
                    'price'=>$reservation->getPrice(),
                    'id' => $id
                ]);
                echo $query->rowCount() . " records UPDATED successfully <br>";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage(); 
            }
        }
}


?>