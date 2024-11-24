<?php
include '../../Controller/eventC.php';
$error = "";

// Create an instance of the controller
$eventC = new eventController();

// Handle form submission
if (
    isset($_POST["id_event"]) &&
    isset($_POST["id_fermier"]) &&
    isset($_POST["nom_event"]) &&
    isset($_POST["location_event"]) &&
    isset($_POST["describtion"]) &&
    isset($_POST["Date"]) &&
    isset($_POST["heure"]) &&
    isset($_POST["duration"]) &&
    isset($_POST["Max_Tickets"]) &&
    isset($_POST["Ticket_price"])
) {
    if (
        !empty($_POST["id_event"]) &&
        !empty($_POST["id_fermier"]) &&
        !empty($_POST["nom_event"]) &&
        !empty($_POST["location_event"]) &&
        !empty($_POST["describtion"]) &&
        !empty($_POST["Date"]) &&
        !empty($_POST["heure"]) &&
        !empty($_POST["duration"]) &&
        !empty($_POST["Max_Tickets"]) &&
        !empty($_POST["Ticket_price"])
    ) {
        $imagePath = null;

        // Handle file upload if present
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/'; // Corrected directory path
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            $imageTmpName = $_FILES['image_url']['tmp_name'];
            $imageName = uniqid() . '_' . basename($_FILES['image_url']['name']);
            $imagePath = $uploadDir . $imageName;

            if (!move_uploaded_file($imageTmpName, $imagePath)) {
                $error = "Failed to upload the image.";
                
            }
        }

        // Create event object
        $event = new Event(
            $_POST['id_fermier'],
            $_POST['nom_event'],
            $_POST['location_event'],
            $_POST['describtion'],
            new DateTime($_POST['Date']),
            $_POST['heure'],
            $_POST['duration'],
            $_POST['Max_Tickets'],
            $_POST['Ticket_price'],
            false, // Example for a default value
            $imagePath
        );

        // Update the event in the database
        if ($eventC->updateEvent($event, $_POST['id_event'])) {
            header('Location: eventacc.php');
            exit();
        } else {
            $error = "Failed to update the event.";
        }
    } else {
        $error = "Missing information.";
    }
} else if (isset($_GET['id_event'])) {
    $event = $eventC->showEvent($_GET['id_event']);
    if (!$event) {
        echo "Event not found.";
        exit();
    }
} else {
    echo "No event ID provided.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link rel="stylesheet" href="up.css">
</head>
<body>
<header>
    <div class="header-content">
        <h1 class="site-title">Tunisia Tour</h1>
        <nav class="nav-links">
            <a href="index.html">Home</a>
            <a href="eventacc.php">Events</a>
        </nav>
    </div>
</header>

<div class="form-container">
    <h2>Update Event</h2>
    <?php if (isset($event)) { ?>
    <form method="post" action="updateevent.php" enctype="multipart/form-data">
        <input type="hidden" id="id_event" name="id_event" value="<?php echo htmlspecialchars($event['id_event']); ?>">
   
        <label for="id_fermier">ID Fermier:</label>
        <input type="text" id="id_fermier" name="id_fermier" value="<?php echo htmlspecialchars($event['id_fermier']); ?>" >

        <label for="nom_event">Nom Event:</label>
        <input type="text" id="nom_event" name="nom_event" value="<?php echo htmlspecialchars($event['nom_event']); ?>" >

        <label for="location_event">Lieu:</label>
        <input type="text" id="location_event" name="location_event" value="<?php echo htmlspecialchars($event['location_event']); ?>" >

        <label for="describtion">Description:</label>
        <input type="text" id="describtion" name="describtion" value="<?php echo htmlspecialchars($event['describtion']); ?>" >

        <label for="Date">Date:</label>
        <input type="date" id="Date" name="Date" value="<?php echo htmlspecialchars($event['Date']); ?>" >

        <label for="heure">Heure:</label>
        <input type="text" id="heure" name="heure" value="<?php echo htmlspecialchars($event['heure']); ?>" >

        <label for="duration">Duree:</label>
        <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($event['duration']); ?>" >

        <label for="Max_Tickets">Capacité:</label>
        <input type="number" id="Max_Tickets" name="Max_Tickets" value="<?php echo htmlspecialchars($event['Max_Tickets']); ?>" >

        <label for="Ticket_price">Prix:</label>
        <input type="number" id="Ticket_price" name="Ticket_price" step="0.01" value="<?php echo htmlspecialchars($event['Ticket_price']); ?>" >

        <label for="image_url">Image:</label>
        <input type="file" id="image_url" name="image_url">
        <?php if (!empty($event['image_url'])) { ?>
            <p>Current Image: <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Current Image" style="max-width: 100px;"></p>
        <?php } ?>

        <div class="button-group">
            <button type="submit">Submit</button>
            <button type="button" onclick="window.location.href='index.html'">Cancel</button>
        </div>
    </form>
    <?php } else { ?>
    <p>No event found with the provided ID.</p>
    <?php } ?>
</div>

<footer>
    <p>&copy; 2024 Tunisia Tour | All Rights Reserved</p>
</footer>
</body>
</html>
