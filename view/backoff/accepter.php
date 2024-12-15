<?php

include '../../Controller/eventC.php';
$eventC = new eventController();
$eventC->acceptEvent($_GET["id_event"]);
 header("Location: eventlist.php");
    
?>  