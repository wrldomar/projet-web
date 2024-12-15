<?php
// Include required files
include '../../Controller/eventC.php';


require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = "";
$event = null;

// Create an instance of the controller
$eventC = new eventController();

// Validate and process form submission
if (
    isset($_POST["id_fermier"]) && isset($_POST["nom_event"]) && isset($_POST["location_event"]) &&
    isset($_POST["describtion"]) && isset($_POST["Date"]) && isset($_POST["heure"]) &&
    isset($_POST["duration"]) && isset($_POST["Max_Tickets"]) && isset($_POST["Ticket_price"])
) {
    // Check if fields are not empty
    if (
        !empty($_POST["id_fermier"]) && !empty($_POST["nom_event"]) && !empty($_POST["location_event"]) &&
        !empty($_POST["describtion"]) && !empty($_POST["Date"]) && !empty($_POST["heure"]) &&
        !empty($_POST["duration"]) && !empty($_POST["Max_Tickets"]) && !empty($_POST["Ticket_price"])
    ) {
        // Handle image upload
        $image_url = null;
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageTmpName = $_FILES['image_url']['tmp_name'];
            $imageName = basename($_FILES['image_url']['name']);
            $imagePath = '../frontoff/' . $uploadDir . uniqid() . '_' . $imageName;

            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $image_url = $imagePath;
            }
        }

        // Create event object
        $event = new event(
            (int)$_POST['id_fermier'],
            $_POST['nom_event'],
            $_POST['location_event'],
            $_POST['describtion'],
            new DateTime($_POST['Date']),
            $_POST['heure'],
            $_POST['duration'],
            (int)$_POST['Max_Tickets'],
            (float)$_POST['Ticket_price'],
            false,  // Default status
            $image_url
        );

        // Add event to the database
        if ($eventC->addevent($event)) {
            // Send confirmation email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'obelhaj488@gmail.com';  // Replace with your email
                $mail->Password = 'ksoa zsug hrlg naos';   // Use a secure app password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('obelhaj488@gmail.com', 'GreenHarvest');
                $userEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

                if ($userEmail) {
                    $mail->addAddress($_POST['email']);
                    $mail->isHTML(true);
                    $mail->Subject = 'Reservation Confirmation - GreenHarvest';
                    $mail->Body = "
                        <h1>Thank you for your reservation!</h1>
                        <p>Dear {$_POST['first-name']} {$_POST['last-name']},</p>
                        <p>You have successfully reserved {$_POST['Max_Tickets']} ticket(s) for the event:</p>
                        <p><strong>{$_POST['nom_event']}</strong></p>
                        <p>Total Price: $" . ($_POST['Max_Tickets'] * $_POST['Ticket_price']) . "</p>
                        <p>We look forward to seeing you at the event!</p>
                    ";

                    $mail->send();
                    header('Location:evenlist.php');  // Redirect on success
                    exit();
                } else {
                    $error = "Event added, but email could not be sent. Invalid email address.";
                }
            } catch (Exception $e) {
                $error = "Event added, but email could not be sent. Error: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Failed to add the event.";
        }
    } else {
        $error = "Missing information. Please fill in all required fields.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>evenment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-content">
      <h1 class="site-title">Tunisia </h1>
      <nav class="nav-links">
        <a href="home.html">Home</a>
        <a href="../backoff/eventacc.php">evenment</a>
      </nav>
    </div>
</header>

<div class="form-container">
    <h2>ajouter evenment</h2>
    
    <form method="post" action="add_event.php" enctype="multipart/form-data">
    <label for="id_fermier">ID Fermier:</label>
    <input type="number" id="id_fermier" name="id_fermier">

    <label for="nom_event">Nom Event:</label>
    <input type="text" id="nom_event" name="nom_event">

    <label for="location_event">Lieu:</label>
    <input type="text" id="location_event" name="location_event">

    <label for="describtion">Description:</label>
    <input type="text" id="describtion" name="describtion">

    <label for="Date">Date:</label>
    <input type="date" id="Date" name="Date">

    <label for="heure">Heure:</label>
    <input type="text" id="heure" name="heure">

    <label for="duration">Duree:</label>
    <input type="text" id="duration" name="duration">

    <label for="Max_Tickets">Capacité:</label>
    <input type="number" id="Max_Tickets" name="Max_Tickets">

    <label for="Ticket_price">Prix:</label>
    <input type="number" id="Ticket_price" name="Ticket_price" step="0.01">

    <label for="image_url">Image:</label>
        <input type="file" id="image_url" name="image_url">
        
    <div class="button-group">
        <button type="submit">Submit</button>
        <button type="button" onclick="window.location.href='index.html'">Cancel</button>
    </div>
</form>


    <footer>
        <p>&copy; 2024 Tunisia Tour | All Rights Reserved</p>
    </footer>

    <script src="validation.js"></script>
</body>
</html>