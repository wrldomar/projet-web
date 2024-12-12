<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash.css" />
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo-details">
        <i class="bx bxl-google"></i>
        <a href="../front/home.html" class="logo-link">
          <span class="logo_name">GreenHarvest</span>
        </a>
      </div>
      <ul class="nav-links">
        <li>
          <a href="../front/home.html" class="active">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-box"></i>
            <span class="links_name">Product</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">Order list</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-coin-stack"></i>
            <span class="links_name">Stock</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-book-alt"></i>
            <span class="links_name">Total order</span>
          </a>
        </li>
        <li>
          <a href="chart.php">
            <i class="bx bx-user"></i>
            <span class="links_name">Chart</span>
          </a>
        </li>
        <li>
          <a href="reser.php">
            <i class="bx bx-message"></i>
            <span class="links_name">Reservations</span>
          </a>
        </li>
        <!-- Events link -->
        <li>
          <a href="eventlist.php">
            <i class="bx bx-calendar-event"></i>
            <span class="links_name">Events</span>
          </a>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
          <input type="text" placeholder="Search..." />
          <i class="bx bx-search"></i>
        </div>
      </nav>
      <style>
      /* General styles */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
      }

      /* Home Section */
      .home-section {
        margin-left: 250px;
        padding: 20px;
        background-color: #f4f7fc;
      }

      .home-content h1 {
        font-size: 32px;
        margin-bottom: 20px;
        color: #333;
      }

      /* Table Container */
      .table-container {
        width: 100%;
        overflow-x: auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      th,
      td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }

      th {
        background-color: #4caf50;
        color: white;
        font-weight: bold;
      }

      td {
        color: #555;
      }

      /* Button Styles */
      .btn-accepter,
      .btn-rejeter,
      .btn-update {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        text-align: center;
        margin-right: 10px;
      }

      .btn-accepter {
        background-color: #4caf50;
      }

      .btn-rejeter {
        background-color: #e53935;
      }

      .btn-update {
        background-color: #fbc02d;
      }

      .btn-accepter:hover {
        background-color: #45a049;
      }

      .btn-rejeter:hover {
        background-color: #d32f2f;
      }

      .btn-update:hover {
        background-color: #f9a825;
      }

      /* Table Row Hover Effect */
      tr:hover {
        background-color: #f1f1f1;
      }
    </style>
      <!-- Main Content Area -->
      <div class="home-content">
        <h1>Event Management</h1>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>id event</th>
                <th>id fermier</th>
                <th>nom_event</th>
                <th>location_event</th>
                <th>description</th>
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
              <?php
              include '../../Controller/eventC.php';
              $eventC = new eventController();
              $list = $eventC->listevent();
              foreach ($list as $event) {
              ?>
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
                  <td>
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
    </section>
  </body>
</html>
