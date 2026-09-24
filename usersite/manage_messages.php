<?php
session_start();
require_once "config.php"; // DB connection

// Fetch messages
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Messages - Admin</title>
  <style>
    body {font-family:Arial;background:#111;color:white;}
    table {width:90%;margin:30px auto;border-collapse:collapse;}
    th, td {padding:10px;border:1px solid #555;text-align:left;}
    th {background:#222;color:yellow;}
    tr:nth-child(even) {background:#222;}
  </style>
</head>
<body>
<h1 style="text-align:center;color:yellow;">User Messages</h1>
<table>
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Date</th>
  </tr>
  <?php
  if($messages->num_rows > 0){
      $i = 1;
      while($row = $messages->fetch_assoc()){
          echo "<tr>
                  <td>".$i++."</td>
                  <td>".htmlspecialchars($row['name'])."</td>
                  <td>".htmlspecialchars($row['email'])."</td>
                  <td>".htmlspecialchars($row['message'])."</td>
                  <td>".$row['created_at']."</td>
                </tr>";
      }
  } else {
      echo "<tr><td colspan='5' style='text-align:center;'>No messages yet.</td></tr>";
  }
  ?>
</table>
</body>
</html>
