<?php
include '../../Controller/reservationcontroller.php';

// Create an instance of the ReservationController
$reservationController = new ReservationController();

// Step 1: Validate the reservation ID from the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Reservation ID is missing!");
} else {
    $reservationId = $_GET['id'];
}

// Step 2: Fetch Reservation Details
$reservation = null;
$reservationsList = $reservationController->listreservations();
foreach ($reservationsList as $res) {
    if ($res['id_reservation'] == $reservationId) {
        $reservation = $res;
        break;
    }
}

if (!$reservation) {
    die("Error: Reservation not found!");
}

// Step 3: Handle Form Submission for Updating Reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are provided and not empty
    if (
        isset($_POST['name'], $_POST['last_name'], $_POST['email'], $_POST['phone_number'], $_POST['nbr_tickets']) &&
        !empty($_POST['name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['phone_number']) && !empty($_POST['nbr_tickets'])
    ) {
        // Retrieve the new number of tickets
        $nbrTickets = (int)$_POST['nbr_tickets'];

        // Calculate the price per ticket based on the existing total price and current number of tickets
        $currentNbrTickets = $reservation['nbr_tickets'];
        $currentPrice = $reservation['price'];
        $ticketPrice = ($currentPrice / $currentNbrTickets); // Calculate the price per ticket

        // Calculate the new total price based on the updated number of tickets
        $newPrice = $nbrTickets * $ticketPrice;

        // Create the updated reservation object (ensure the Reservation class matches this constructor)
        $updatedReservation = new Reservation(
            null, // Use the existing reservation ID
            $reservation['id_event'],       // Existing event ID
            $_POST['name'],           // First Name
            $_POST['last_name'],            // Last Name
            $_POST['email'],                // Email
            $_POST['phone_number'],         // Phone Number
            $nbrTickets,                    
            $newPrice             
        );

        // Update the reservation in the database
        $updateSuccess = $reservationController->updatereservation($updatedReservation, $reservationId);

        if (!$updateSuccess) {
            
            header('Location: reser.php?message=Reservation updated successfully!');
            exit();
        } else {
            $error = "Failed to update the reservation.";
        }
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="container">
        <h2>Edit Reservation</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Form to edit reservation details -->
        <form action="editreservation.php?id=<?php echo htmlspecialchars($reservation['id_reservation']); ?>" method="POST">
            <div class="form-row">
                <label for="name">First Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($reservation['name']); ?>" >

                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($reservation['last_name']); ?>" >

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reservation['email']); ?>" >

                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($reservation['phone_number']); ?>" >

                <label for="nbr_tickets">Number of Tickets</label>
                <input type="number" id="nbr_tickets" name="nbr_tickets" value="<?php echo htmlspecialchars($reservation['nbr_tickets']); ?>" min="1" >
            </div>

            <div class="form-row buttons">
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='reser.php'">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
