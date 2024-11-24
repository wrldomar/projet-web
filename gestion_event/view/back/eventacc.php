<?php

include '../../Controller/eventC.php';
include '../../Controller/reservationcontroller.php';

// Create an instance of the class that contains the method to fetch agriculture events
$eventC = new eventController();

// Fetch the list of agriculture-related events with Status = 1
$list = $eventC->listeventaccepted();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Events - Tunisia Tour</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo">Tunisia Agriculture Tours</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="../addreservation.php">Home</a></li>
                    <li><a href="#">Agriculture Events</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="events-container">
        <h2>Upcoming Agricultural Events</h2>
        <div class="event-list">
        <?php foreach ($list as $event) { ?>
    <div class="event-item">
        <!-- Check if image_url exists and is not empty -->
        <?php if (!empty($event['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Image">
        <?php else: ?>
            No image
        <?php endif; ?>
        <div class="event-details">
            <h3><?= htmlspecialchars($event['nom_event']); ?></h3>
            <p><strong>Date:</strong> <?= $event['Date']; ?></p>
            <p><strong>Time:</strong> <?= $event['heure']; ?></p>
            <p><strong>Duration:</strong> <?= $event['duration']; ?> hours</p>
            <p><strong>Location:</strong> <?= htmlspecialchars($event['location_event']); ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($event['describtion']); ?></p>
            <p><strong>Price:</strong> <?= $event['Ticket_price']; ?> DT</p>
            <p><strong>Capacity:</strong> <?= $event['Max_Tickets']; ?> people</p>
            <!-- Link to the reservation page with the event ID -->
            <a href="../front/addreservation.php?id_event=<?= htmlspecialchars($event['id_event']); ?>" class="reserve-btn">RESERVE</a>



        </div>
    </div>
<?php } ?>

        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Tunisia Agriculture Tours | All Rights Reserved</p>
    </footer>
</body>
</html>
