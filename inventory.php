<?php
include 'auth.php';
include 'db.php';
checkAuth();

$stmt = $pdo->query("SELECT * FROM inventory");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory - Management</title>
  
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css"> <!-- Using existing dashboard.css -->

  <!-- JS -->
  <script src="js/main.js"></script>
  <script src="js/form-validation.js"></script>
  <script src="js/dashboard.js"></script>
</head>
<body>

<div class="container">
  <h1>📦 Inventory Management</h1>
  <h2>Inventory</h2>

  <!-- Inventory Table -->
  <table class="inventory-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Serial No</th>
        <th>Location</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= $item['id'] ?></td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= htmlspecialchars($item['serial_no']) ?></td>
          <td><?= htmlspecialchars($item['location']) ?></td>
          <td>
            <?php if (in_array('admin', explode(',', $_SESSION['user']['roles']))): ?>
              <a href="edit.php?id=<?= $item['id'] ?>" class="btn edit">Edit</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add New Item Button -->
  <?php if (in_array('admin', explode(',', $_SESSION['user']['roles']))): ?>
    <div class="btn-group">
      <a class="btn primary" href="add_item.php">➕ Add New Item</a>
    </div>
  <?php endif; ?>
  
</div>

</body>
</html>
