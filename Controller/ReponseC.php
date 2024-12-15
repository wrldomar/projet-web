<?php
include '../../config.php';
include '../../model/Reponse.php';

class ReponseC
{
    public function listreponse()
    {
        $sql = "SELECT * FROM reponse";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deletereponse($id_rep)
    {
        $sql = "DELETE FROM reponse WHERE id_rep = :id_rep";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_rep', $id_rep);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addreponse($reponse)
{
    $sql = "INSERT INTO reponse (id_rep, idrec, reponse, date_reponse) 
            VALUES (NULL, :idrec, :reponse, :date_reponse)";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'idrec' => $reponse->getidrec(),
            'reponse' => $reponse->getreponse(),
            'date_reponse' => $reponse->getdate_rep()->format('Y-m-d'),
        ]);
        echo "Data inserted successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


    function updatereponse($reponse, $id_rep)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE reponse SET 
                    idrec = :idrec, 
                    reponse = :reponse, 
                    date_reponse = :date_reponse
                    
                WHERE id_rep= :id_rep'
            );
            $query->execute([
                'id_rep' => $id_rep,
                'idrec' => $reponse->getidrec(),
                'reponse' => $reponse->getreponse(),
                'date_reponse' => $reponse->getdate_rep()->format('Y/m/d')
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function showreponse($id_rep)
    {
        $sql = "SELECT * from reponse where id_rep = $id_rep";
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
    
}
