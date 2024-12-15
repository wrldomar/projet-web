<?php
include_once '../../Controller/ReclamationC.php';


$reclamationC = new ReclamationC();
$list = $reclamationC->listreclamation();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reclamations List</title>
  <link rel="stylesheet" href="dash.css" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #2e8b57;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 30px;
    }

    .sidebar .logo-details {
      display: flex;
      align-items: center;
      justify-content: center;
      padding-bottom: 20px;
    }

    .sidebar .logo-details i {
      font-size: 30px;
      color: #fff;
    }

    .sidebar .logo-details .logo_name {
      font-size: 24px;
      color: #fff;
      margin-left: 10px;
    }

    .sidebar ul {
      list-style-type: none;
    }

    .sidebar ul li a {
      display: block;
      padding: 15px 20px;
      color: #fff;
      text-decoration: none;
      transition: background 0.3s;
    }

    .sidebar ul li a:hover {
      background-color: #28a745;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
      flex-grow: 1;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    h2 a {
      text-decoration: none;
      color: #28a745;
      font-size: 16px;
      padding: 10px;
      background-color: #f4f4f9;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    h2 a:hover {
      background-color: #28a745;
      color: white;
    }

    #reclamationsTable {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #reclamationsTable th, #reclamationsTable td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    #reclamationsTable th {
      background-color: #28a745;
      color: white;
    }

    #reclamationsTable td a {
      color: #e74c3c;
      text-decoration: none;
    }

    #reclamationsTable td a:hover {
      color: #c0392b;
    }

    button {
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class="bx bxl-google"></i>
      <a href="../frontoff/home.html" class="logo-link">
        <span class="logo_name">GreenHarvest</span>
      </a>
    </div>
    <ul class="nav-links">
      <li><a href="listreclamation.php" class="active"><i class="bx bx-grid-alt"></i>Reclamations</a></li>
      <li><a href="../frontoff/home.html"><i class="bx bx-box"></i>Product</a></li>
      <li><a href="list.php"><i class="bx bx-list-ul"></i>User</a></li>
      <li><a href="#"><i class="bx bx-coin-stack"></i>Stock</a></li>
      <li><a href="listreponse.php"><i class="bx bx-book-alt"></i>reponse</a></li>
      <li><a href="chart.php"><i class="bx bx-user"></i>Chart</a></li>
      <li><a href="reser.php"><i class="bx bx-message"></i>Reservations</a></li>
      <li><a href="eventlist.php"><i class="bx bx-calendar-event"></i>Events</a></li>
    </ul>
  </div>

  <div class="content">
    <h1>List of Reclamations</h1>
    <h2><a href="addreclamation.php">Add Reclamation</a></h2>
    <table id="reclamationsTable">
      <thead>
        <tr>
          <th>Id Reclamation</th>
          <th>Sujet</th>
          <th>Date</th>
          <th>Description</th>
          <th>Update</th>
          <th>Delete</th>
          <th>Response</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($list)): ?>
          <?php foreach ($list as $reclamation): ?>
            <tr>
              <td><?= htmlspecialchars($reclamation['id_rec']); ?></td>
              <td><?= htmlspecialchars($reclamation['sujet']); ?></td>
              <td><?= htmlspecialchars($reclamation['date']); ?></td>
              <td><?= htmlspecialchars($reclamation['description']); ?></td>
              <td><form method="POST" action="updatereclamation.php">
                <input type="submit" name="update" value="Update">
                <input type="hidden" name="id_rec" value="<?= htmlspecialchars($reclamation['id_rec']); ?>">
              </form></td>
              <td><a href="deletereclamation.php?id_rec=<?= htmlspecialchars($reclamation['id_rec']); ?>">Delete</a></td>
              <td><a href="../frontoff/addreponse.php?id_rec=<?= htmlspecialchars($reclamation['id_rec']); ?>">Response</a></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" align="center">No reclamations found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    
  </div>
</body>
</html>