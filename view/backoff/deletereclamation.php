<?php
include '../../Controller/ReclamationC.php';
$reclamationC = new ReclamationC();
$reclamationC->deletereclamation($_GET["id_rec"]);
header('Location:listreclamation.php');
