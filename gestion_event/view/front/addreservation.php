<?php
// Include necessary files
include '../../Controller/reservationcontroller.php';  // Reservation controller class
include '../../Controller/eventC.php';  // Event controller class

// Initialize controllers
$reservationController = new ReservationController();
$eventController = new eventController();

// Variable to store any errors
$error = "";

// Get the event ID from the URL (after clicking "RESERVE" on the back-end page)
$id_event = isset($_GET['id_event']) ? $_GET['id_event'] : null;
$event = null;

// Fetch event details if id_event is provided
if ($id_event) {
    $event = $eventController->showEvent($id_event); // Using showEvent to fetch the event by ID
}

if (
    isset($_POST["id_event"]) && isset($_POST["first-name"]) && isset($_POST["last-name"]) &&
    isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["tickets"])
) {
    if (
        !empty($_POST["id_event"]) && !empty($_POST["first-name"]) && !empty($_POST["last-name"]) &&
        !empty($_POST["email"]) && !empty($_POST["phone"]) && !empty($_POST["tickets"])
    ) {
        // Calculate the price based on the number of tickets
        $ticketPrice = 20; // Example price per ticket
        $numberOfTickets = $_POST['tickets'];
        $totalPrice = $ticketPrice * $numberOfTickets;

        // Create a Reservation object using the form data and calculated price
        $reservation = new Reservation(
            null, // ID will be auto-generated
            $_POST['id_event'], 
            $_POST['first-name'],
            $_POST['last-name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['tickets'],
            $totalPrice // Calculated price
        );

        // Call the addReservation method from the controller to insert the data
        $reservationController->addReservation($reservation);

        // Redirect to a confirmation page or reservation list (adjust URL as needed)
        // header('Location: reservationList.php'); // Redirect after successful reservation
        exit;
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GreenHarvest - Vegetable & Fruit Event Reservation</title>
    <link rel="stylesheet" href="rescss.css" />
    <script src="reserv.js" defer></script>
  </head>
  <body>
    <div class="header-bar">
      <h1 class="site-title">GreenHarvest</h1>
     
    </div>

    <header></header>

    <section class="reservation-form">
      <h2>Reserve Your Spot</h2>

      <?php if ($event): ?>
        <!-- Show event details before the form -->
        <h3>Event: <?= htmlspecialchars($event['nom_event']); ?></h3>
        <p><strong>Date:</strong> <?= $event['Date']; ?></p>
        <p><strong>Time:</strong> <?= $event['heure']; ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location_event']); ?></p>

        <!-- Form to reserve tickets -->
        <form action="addreservation.php" method="POST">
        <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($reservations['id_reservation']); ?>">


        <input type="hidden" name="id_event" value="<?= htmlspecialchars($event['id_event']); ?>">

          

          <label for="first-name">First Name</label>
          <input type="text" id="first-name" name="first-name" placeholder="Your First Name"  />
          <span id="first-name-message"></span>

          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" name="last-name" placeholder="Your Last Name"  />
          <span id="last-name-message"></span>

          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Your Email"  />
          <span id="email-message"></span>

          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" placeholder="Your Phone Number"  />
          <span id="phone-message"></span>

          <label for="tickets">Number of Tickets</label>
          <input type="number" id="tickets" name="tickets" min="1" max="100" placeholder="Enter number of tickets"  />
          <span id="tickets-message"></span>

          <div class="button-group">
            <button type="submit" class="reserve-btn">Reserve Now</button>
            <button type="button" class="cancel-btn">Cancel</button>
          </div>
        </form>

      <?php else: ?>
        <p>Event not found.</p>
      <?php endif; ?>
    </section>

    <footer>
      <p>&copy; 2024 GreenHarvest. All rights reserved.</p>
    </footer>
  </body>
</html>
