<?php
include '../../Controller/reservationcontroller.php';
include '../../Controller/eventC.php';

$reservationscontroller = new ReservationController();
$list = $reservationscontroller->listreservations();  // Ensure this is returning data
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservations Dashboard</title>
    <link rel="stylesheet" href="reser.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  </head>
  <body>
    <nav>
      <div class="logo">
        <a href="dashboard.html"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
      </div>
    </nav>

    <div class="dashboard">
      <h1>Reservations Dashboard</h1>
      <div class="table-container">
        <table class="reservation-table">
          <thead>
            <tr>
              <th>ID Reservation</th>
              <th>Event ID</th>
              <th>Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Number of Tickets</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list as $reservation): ?>
              <tr>
                <!-- Check if id_reservation key exists -->
                <td><?php echo htmlspecialchars($reservation['id_reservation']); ?></td>
                <td><?php echo htmlspecialchars($reservation['id_event']); ?></td>
                <td><?php echo htmlspecialchars($reservation['name']); ?></td>
                <td><?php echo htmlspecialchars($reservation['last_name']); ?></td>
                <td><?php echo htmlspecialchars($reservation['email']); ?></td>
                <td><?php echo htmlspecialchars($reservation['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($reservation['nbr_tickets']); ?></td>
                <td><?php echo htmlspecialchars($reservation['price']); ?></td>
                <td>
                  <!-- Delete Button -->
                  <form method="POST" action="deleltereservation.php" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                    <input type="hidden" name="id_reservation" value="<?php echo isset($reservation['id_reservation']) ? $reservation['id_reservation'] : ''; ?>" />
                    <button type="submit" class="delete-button"><i class="fas fa-trash"></i> Delete</button>
                  </form>
                  <!-- Edit Button -->
                  <a href="editreservation.php?id=<?php echo isset($reservation['id_reservation']) ? $reservation['id_reservation'] : ''; ?>" class="btn btn-edit">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
