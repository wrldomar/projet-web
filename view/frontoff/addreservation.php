<?php
// Include necessary files
include '../../Controller/reservationcontroller.php';  // Reservation controller class
include '../../Controller/eventC.php';  // Event controller class

// Load Composer's autoloader for PHPMailer
require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize controllers
$reservationController = new ReservationController();
$eventController = new eventController();

// Variable to store any errors or success messages
$message = "";

// Get the event ID from the URL (after clicking "RESERVE" on the back-end page)
$id_event = isset($_GET['id_event']) ? $_GET['id_event'] : null;
$event = null;

// Fetch event details if id_event is provided
if ($id_event) {
    $event = $eventController->showEvent($id_event);
}

// Function to verify Google reCAPTCHA
function verifyReCaptcha($recaptchaResponse) {
    $secretKey = '6LcFGZYqAAAAAA_aPe6HL3sAWOgvZvWXM2iRXkIr'; // Replace with your reCAPTCHA secret key
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse";

    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    
    return isset($responseKeys["success"]) && $responseKeys["success"] === true;
}

if (
    isset($_POST["id_event"]) && isset($_POST["first-name"]) && isset($_POST["last-name"]) &&
    isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["tickets"]) &&
    isset($_POST["g-recaptcha-response"])
) {
    // Verify reCAPTCHA response
    $recaptchaResponse = $_POST["g-recaptcha-response"];
    if (!verifyReCaptcha($recaptchaResponse)) {
        $message = "thank you";
    } else {
        // Check if all form fields are filled
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

            // Add reservation to the database
            $reservationController->addReservation($reservation);

            // Send confirmation email
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'obelhaj488@gmail.com'; // Replace with your email
                $mail->Password   = 'ksoa zsug hrlg naos';   // Replace with your email password
                $mail->SMTPSecure = 'ssl'; 
                $mail->Port       = 465;

                // Recipients
                $mail->setFrom('obelhaj488@gmail.com', 'GreenHarvest');
                $mail->addAddress($_POST['email']); // Send email to the user

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Reservation Confirmation - GreenHarvest';
                $mail->Body    = '<h1>Thank you for your reservation!</h1>' .
                    '<p>Dear ' . htmlspecialchars($_POST['first-name']) . ' ' . htmlspecialchars($_POST['last-name']) . ',</p>' .
                    '<p>You have successfully reserved ' . $numberOfTickets . ' ticket(s) for the event: ' .
                    '<p><strong>Event Details:</strong></p>' .
                    '<p>Total Price: $' . $totalPrice . '</p>' .
                    '<p>We look forward to seeing you at the event!</p>';

                // Send email
                $mail->send();
                // Success message
                $message = "Your reservation was successful! A confirmation email has been sent.";
            } catch (Exception $e) {
                $message = "Reservation made but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $message = "All fields are required!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GreenHarvest - Vegetable & Fruit Event Reservation</title>
    <link rel="stylesheet" href="res.css" />
    <script src="res.js" defer></script>

    <!-- Inline CSS for the buttons -->
    <style>
      /* Style for the buttons */
      .button-group {
        margin-top: 20px;
        text-align: center;
      }

      .button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin: 5px;
        font-size: 16px;
        cursor: pointer;
        display: inline-block;
      }

      .button:hover {
        background-color: #0056b3;
      }
    </style>
  </head>

  <body>
    <div class="header-bar">
      <h1 class="site-title">GreenHarvest</h1>
    </div>

    <header></header>

    <section class="reservation-form">
      <h2>Reserve Your Spot</h2>

      <!-- Display success message -->
      <?php if ($message): ?>
        <div class="success-message">
          <p><?= htmlspecialchars($message); ?></p>
          
          <!-- Add buttons to navigate to home or view event -->
          <div class="button-group">
            <!-- Go to Home button -->
            <a href="home.html" class="button">Go to Home</a>
            
            <!-- View Event button -->
            <a href="../back/eventacc.php" class="button">View Event</a>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($event): ?>
        <!-- Show event details before the form -->
        <h3>Event: <?= htmlspecialchars($event['nom_event']); ?></h3>
        <p><strong>Date:</strong> <?= $event['Date']; ?></p>
        <p><strong>Time:</strong> <?= $event['heure']; ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location_event']); ?></p>

        <!-- Form to reserve tickets -->
        <form action="addreservation.php" method="POST">
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

          <!-- reCAPTCHA widget -->
          <div class="g-recaptcha" data-sitekey="6LcFGZYqAAAAAD7lBXz6zQrFh_-AsnhgcspoxC2_"></div>
          <span id="recaptcha-message"></span>

          <div class="button-group">
            <button type="submit" class="reserve-btn">Reserve Now</button>
            <button type="button" class="cancel-btn">Cancel</button>
          </div>
        </form>

      <?php else: ?>
        <p></p>
      <?php endif; ?>
    </section>

    <footer>
      <p>&copy; 2024 GreenHarvest. All rights reserved.</p>
    </footer>

    <!-- Load reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
</html>
