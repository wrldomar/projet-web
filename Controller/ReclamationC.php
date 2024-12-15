<?php
include '../../config.php';
include '../../model/Reclamation.php';

class ReclamationC
{
    public function listreclamation()
    {
        $sql = "SELECT * FROM reclamation";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deletereclamation($id_rec)
    {
        $sql = "DELETE FROM reclamation WHERE id_rec = :id_rec";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_rec', $id_rec);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addreclamation($reclamation)
{
    $sql = "INSERT INTO reclamation (id_rec, sujet, date, description) 
            VALUES (NULL, :sujet, :date, :description)";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'sujet' => $reclamation->getsujet(),
            'date' => $reclamation->getdate()->format('Y-m-d'),
            'description' => $reclamation->getdescription()
           
        ]);
        echo "Data inserted successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


    function updatereclamation($reclamation, $id_rec)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE reclamation SET 
                    sujet = :sujet, 
                    date = :date, 
                    description = :description 
                WHERE id_rec= :id_rec'
            );
            $query->execute([
                'id_rec' => $id_rec,
                'sujet' => $reclamation->getsujet(),
                'date' => $reclamation->getdate()->format('Y/m/d'),
                'description' => $reclamation->getdescription()
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function showreclamation($id_rec)
    {
        $sql = "SELECT * from reclamation where id_rec = $id_rec";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $employe = $query->fetch();
            return $employe;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    function searchReclamationById($id_rec)
{
    $sql = "SELECT * FROM reclamation WHERE id_rec = :id_rec";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindValue(':id_rec', $id_rec);
        $query->execute();

        $reclamation = $query->fetch();
        return $reclamation ? $reclamation : null; // Return the record or null if not found
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

}
