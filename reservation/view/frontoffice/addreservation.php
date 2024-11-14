<?php
// Include necessary files// Reservation model class
include '../../controller/reservationcontroller.php'; // Reservation controller class

// Initialize the ReservationController
$reservationController = new ReservationController();

// Variable to store any errors
$error = "";

// Check if form is submitted and necessary fields are provided
if (
    isset($_POST["id_event"]) && isset($_POST["first-name"]) && isset($_POST["last-name"]) &&
    isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["tickets"])
) {
    if (
        !empty($_POST["id_event"]) && !empty($_POST["first-name"]) && !empty($_POST["last-name"]) &&
        !empty($_POST["email"]) && !empty($_POST["phone"]) && !empty($_POST["tickets"])
    ) {
        // Calculate the price based on the number of tickets
        $ticketPrice = 20; // Example price per ticket (adjust as needed)
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
            $totalPrice // Use the calculated price here
        );

        // Call the addReservation method from the controller to insert the data
        $reservationController->addReservation($reservation);

        // Redirect to a confirmation page or reservation list (adjust URL as needed)
        //header('Location: reservationList.php'); // Redirect after successful reservation
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
  </head>
  <body>
    <div class="header-bar">
      <h1 class="site-title">GreenHarvest</h1>
      <nav>
        <button onclick="location.href='#'">Home</button>
        <button onclick="location.href='#'">Contact</button>
        <button onclick="location.href='#'">Shop</button>
      </nav>
    </div>

    <header></header>

    <section class="reservation-form">
      <h2>Reserve Your Spot</h2>
      <!-- Form starts here -->
      <form action="addreservation.php" method="POST">
      <input type="hidden" name="id_event" value="1"> <!-- Replace 1 with the actual event ID -->
        <label for="first-name">First Name</label>
        <input
          type="text"
          id="first-name"
          name="first-name"
          placeholder="Your First Name"
        />

        <label for="last-name">Last Name</label>
        <input
          type="text"
          id="last-name"
          name="last-name"
          placeholder="Your Last Name"
        />

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Your Email" />

        <label for="phone">Phone Number</label>
        <input
          type="tel"
          id="phone"
          name="phone"
          placeholder="Your Phone Number"
        />

        <label for="tickets">Number of Tickets</label>
        <input
          type="number"
          id="tickets"
          name="tickets"
          min="1"
          max="100"
          placeholder="Enter number of tickets"
        />

        <div class="button-group">
          <button type="submit" class="reserve-btn">Reserve Now</button>
          <button type="button" class="cancel-btn" >
            Cancel
          </button>
        </div>
      </form>
      <!-- Form ends here -->
    </section>

    <footer>
      <p>&copy; 2024 GreenHarvest. All rights reserved.</p>
    </footer>
  </body>
</html>
