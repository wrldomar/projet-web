<?php
include '../../Controller/reservationcontroller.php';
$reservationcontroller = new ReservationController();
$reservationcontroller->deleteOffer($_POST["id_reservation"]);
header('Location:reser.php');
