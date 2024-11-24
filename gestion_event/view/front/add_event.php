<?php
include '../../Controller/eventC.php';
$error = "";

$event = null;
// create an instance of the controller
$eventC = new eventController();

if (
    isset($_POST["id_fermier"]) && isset($_POST["nom_event"]) && isset($_POST["location_event"]) &&
    isset($_POST["describtion"]) && isset($_POST["Date"]) && isset($_POST["heure"]) &&
    isset($_POST["duration"]) && isset($_POST["Max_Tickets"]) && isset($_POST["Ticket_price"])
) {
    // Validate that required fields are not empty
    if (
        !empty($_POST["id_fermier"]) && !empty($_POST["nom_event"]) && !empty($_POST["location_event"]) &&
        !empty($_POST["describtion"]) && !empty($_POST["Date"]) && !empty($_POST["heure"]) &&
        !empty($_POST["duration"]) && !empty($_POST["Max_Tickets"]) && !empty($_POST["Ticket_price"])
    ) {
        // Process the image upload if present
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/'; // Directory to store uploaded images
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }
    
            $imageTmpName = $_FILES['image_url']['tmp_name'];
            $imageName = basename($_FILES['image_url']['name']);
            $imagePath ='../front/'. $uploadDir . uniqid() . '_' . $imageName;


            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $image_url = $imagePath;
            } else {
                $image_url = null; // Handle upload failure
            }
        }

        // Create event object
        $event = new event(
            (int) $_POST['id_fermier'],               // Cast id_agence to integer
            $_POST['nom_event'],                     // Event name
            $_POST['location_event'],                // Event location
            $_POST['describtion'],                   // Event description
            new DateTime($_POST['Date']),            // Event date
            $_POST['heure'],                         // Event time
            $_POST['duration'],                      // Event duration
            (int) $_POST['Max_Tickets'],             // Maximum tickets
            (float) $_POST['Ticket_price'],          // Ticket price
            false,                                   // Example: Use default value for "status"
            $imagePath                 
        );
       

        // Add event to the database
        if ($eventC->addevent($event)) {
            header('Location:evenlist.php'); // Redirect to event list on success
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
        <a href="">Home</a>
        <a href="">evenment</a>
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