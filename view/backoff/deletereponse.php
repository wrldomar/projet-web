<?php
include '../../Controller/ReponseC.php';
$reponseC = new ReponseC();
$reponseC->deletereponse($_GET["id_rep"]);
header('Location:listreponse.php');
