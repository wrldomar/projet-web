<?php

include '../../Controller/eventC.php';
$eventC = new eventController();
$eventC->deleteevent($_GET["id_event"]);
 header("Location: eventlist.php");
    
?>  