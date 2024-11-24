<?php
include '../../Controller/eventC.php';
$eventC = new eventController();
$list = $eventC->listevent();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice Dashboard</title>
    <link rel="stylesheet" href="backstyles.css">
</head>
<body>

<!-- Navbar Section -->
<div class="navbar">
    <div class="navbar-container">
    <a href="dashboard.html"><i class="logo"></i> Dashboard</a>
    </div>
</div>

<div class="dashboard-container">
    <h1>Event Management</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>id event</th>
                    <th>id fermier</th>
                    <th>nom_event</th>
                    <th>location_event</th>
                    <th>describtion</th>
                    <th>Date</th>
                    <th>heure</th>
                    <th>duration</th>
                    <th>Max_Tickets</th>
                    <th>Ticket_price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $event) { ?>
                <tr>
                    <td><?= $event['id_event']; ?></td>
                    <td><?= $event['id_fermier']; ?></td>
                    <td><?= $event['nom_event']; ?></td>
                    <td><?= $event['location_event']; ?></td>
                    <td><?= $event['describtion']; ?></td>
                    <td><?= $event['Date']; ?></td>
                    <td><?= $event['heure']; ?></td>
                    <td><?= $event['duration']; ?></td>
                    <td><?= $event['Max_Tickets']; ?></td>
                    <td><?= $event['Ticket_price']; ?></td>
                    <td><?= $event['Status']; ?></td>
                    <td width="400px">
                        <a class="btn-accepter" href="accepter.php?id_event=<?php echo $event['id_event']; ?>">Accepter</a>
                        <a class="btn-rejeter" href="delete.php?id_event=<?php echo $event['id_event']; ?>">Delete</a>
                        <a class="btn-update" href="updateevent.php?id_event=<?= $event['id_event']; ?>">Update</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
