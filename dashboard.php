<?php
include 'auth.php';
checkAuth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="container">
  <h1>👋 Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></h1>
  <p class="user-info">Roles: <strong><?= htmlspecialchars($_SESSION['user']['roles']) ?></strong></p>

  <div class="btn-group">
    <a class="btn" href="index.php">🏠 Home</a>
    <a class="btn" href="printer_list.php">🖨️ Printer Management</a>
    <a class="btn" href="pc_list.php">🖥️ PC Management</a>
    <a class="btn danger" href="logout.php">🚪 Logout</a>
  </div>
</div>

<!-- JS -->
<script src="js/main.js"></script>
<script src="js/form-validation.js"></script>
<script src="js/dashboard.js"></script>
</body>
</html>
