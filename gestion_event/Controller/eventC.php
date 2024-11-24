<?php
require_once '../../config.php';
require_once '../../model/event.php';

class eventController {
    public function listevent(){
        $sql="SELECT * FROM event";
        $db=config::getConnexion();
        try{
            $liste=$db->query($sql);
            return $liste;
        }catch(Exception $e){
            die('Error;' . $e->getMessage());
        }
    }

    public function listeventaccepted(){
        $sql="SELECT * FROM event WHERE Status = 1";
        $db=config::getConnexion();
        try{
            $liste=$db->query($sql);
            return $liste;
        }catch(Exception $e){
            die('Error;' . $e->getMessage());
        }
    }
  
    public function deleteevent($id_event){
        $sql="DELETE FROM event WHERE id_event= :id_event";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_event', $id_event);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addevent(event $event) {
        $sql = "INSERT INTO event (id_fermier, nom_event, location_event, describtion, Date, heure, duration, Max_Tickets, Ticket_price, Status, image_url) 
                VALUES (:id_fermier, :nom_event, :location_event, :describtion, :Date, :heure, :duration, :Max_Tickets, :Ticket_price, 0, :image_url)";  

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_fermier' => $event->getIdfermier(),
                'nom_event' => $event->getNomEvent(),
                'location_event' => $event->getLocationEvent(),
                'describtion' => $event->getDescription(),
                'Date' => $event->getDate()->format('Y-m-d'),
                'heure' => $event->getHeure(),
                'duration' => $event->getDuration(),
                'Max_Tickets' => $event->getMaxTickets(),
                'Ticket_price' => $event->getTicketPrice(),
                'image_url' => $event->getImageUrl()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function acceptEvent($id_event){
        $sql="UPDATE event SET Status = 1 WHERE id_event= :id_event";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_event', $id_event);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateEvent(event $event, $id_event) {
        $sql = "UPDATE event SET 
                id_fermier = :id_fermier,
                nom_event = :nom_event,
                location_event = :location_event,
                describtion = :describtion,
                Date = :Date,
                heure = :heure,
                duration = :duration,
                Max_Tickets = :Max_Tickets,
                Ticket_price = :Ticket_price,
                image_url = :image_url
            WHERE id_event = :id_event";

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_event' => $id_event,
                'id_fermier' => $event->getIdfermier(),
                'nom_event' => $event->getNomEvent(),
                'location_event' => $event->getLocationEvent(),
                'describtion' => $event->getDescription(),
                'Date' => $event->getDate()->format('Y-m-d'),
                'heure' => $event->getHeure(),
                'duration' => $event->getDuration(),
                'Max_Tickets' => $event->getMaxTickets(),
                'Ticket_price' => $event->getTicketPrice(),
                'image_url' => $event->getImageUrl() // Add the image_url field
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function showEvent($id_event) {
        $sql = "SELECT * FROM event WHERE id_event = :id_event";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id_event', $id_event);
            $query->execute();
            return $query->fetch(); // Fetch the event details by id_event
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

}
?>