<?php
include '../../Controller/ReponseC.php';
$reponseC = new ReponseC();
$responses = $reponseC->listreponse(); // Use $responses here
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of Responses</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
      flex-grow: 1;
    }
    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    table th, table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    table th {
      background-color: #28a745;
      color: white;
    }
    h1, h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    h2 a {
      text-decoration: none;
      color: #28a745;
      padding: 10px;
      background-color: #f4f4f9;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    h2 a:hover {
      background-color: #28a745;
      color: white;
    }
  </style>
</head>
<body>

  <div class="content">
    <h1>List of Responses</h1>

    <table id="responsesTable">
      <thead>
        <tr>
          <th>Id Response</th>
          <th>Id Reclamation</th>
          <th>Response</th>
          <th>Date Response</th>
          <th>Update</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
  <?php if (!empty($responses)): ?>
    <?php foreach ($responses as $response): ?>
      <tr>
        <td><?= htmlspecialchars($response['id_rep']); ?></td>
        <td><?= htmlspecialchars($response['idrec']); ?></td>
        <td><?= htmlspecialchars($response['reponse']); ?></td>
        <td><?= htmlspecialchars($response['date_reponse']); ?></td>
        <td>
          <form method="POST" action="updatereponse.php">
            <input type="submit" name="update" value="Update">
            <input type="hidden" name="id_rep" value="<?= htmlspecialchars($response['id_rep']); ?>">
          </form>
        </td>
        <td><a href="deletereponse.php?id_rep=<?= htmlspecialchars($response['id_rep']); ?>">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="6" align="center">No responses found.</td></tr>
  <?php endif; ?>
</tbody>

    </table>
  </div>

</body>
</html>
