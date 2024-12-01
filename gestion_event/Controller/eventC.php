<?php
require_once '../../config.php';
require_once '../../model/event.php';

class eventController {
    public function listevent() {
        $sql = "SELECT * FROM event";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function listeventaccepted() {
        $sql = "SELECT * FROM event WHERE Status = 1";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteevent($id_event) {
        $sql = "DELETE FROM event WHERE id_event = :id_event";
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

    public function acceptEvent($id_event) {
        $sql = "UPDATE event SET Status = 1 WHERE id_event = :id_event";
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
                'image_url' => $event->getImageUrl()
            ]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function showEvent($id_event)
{
    $db = config::getConnexion();
    $sql = "SELECT * FROM event WHERE id_event = :id_event";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_event' => $id_event]);

    // Debugging: Check the number of rows returned
    echo "Rows returned: " . $stmt->rowCount() . "<br>";

    if ($stmt->rowCount() > 0) {
        // Fetch and return the event data
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Event details: " . htmlspecialchars(print_r($event, true)) . "<br>";
        return $event; // Return the event data if found
    } else {
        // If no event is found, return null
        echo "No event found for ID: " . htmlspecialchars($id_event) . "<br>";
        return null;
    }
}


    

    // New: Search and paginate events
    public function searchAndPaginateEvents($search, $startDate, $endDate, $limit, $offset) {
        $sql = "SELECT * FROM event 
                WHERE Status = 1 
                AND (nom_event LIKE :search OR location_event LIKE :search) 
                AND (:startDate IS NULL OR Date >= :startDate)
                AND (:endDate IS NULL OR Date <= :endDate)
                LIMIT :limit OFFSET :offset";

        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->bindValue(':startDate', $startDate ?: null, PDO::PARAM_STR);
            $stmt->bindValue(':endDate', $endDate ?: null, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // New: Count filtered events
    public function countFilteredEvents($search, $startDate, $endDate) {
        $sql = "SELECT COUNT(*) as count FROM event 
                WHERE Status = 1 
                AND (nom_event LIKE :search OR location_event LIKE :search) 
                AND (:startDate IS NULL OR Date >= :startDate)
                AND (:endDate IS NULL OR Date <= :endDate)";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->bindValue(':startDate', $startDate ?: null, PDO::PARAM_STR);
            $stmt->bindValue(':endDate', $endDate ?: null, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Count events within a specific week
    public function countWeeklyEvents($startOfWeek, $endOfWeek) {
        $db = config::getConnexion();
        $query = "SELECT COUNT(*) as count FROM event 
                  WHERE Status = 1 AND Date BETWEEN :startOfWeek AND :endOfWeek";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':startOfWeek', $startOfWeek, PDO::PARAM_STR);
        $stmt->bindValue(':endOfWeek', $endOfWeek, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
