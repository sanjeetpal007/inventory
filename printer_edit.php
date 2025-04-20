<?php
include 'auth.php';
include 'db.php';
checkAuth(['admin', 'user']);

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM printer WHERE id = ?");
$stmt->execute([$id]);
$printer = $stmt->fetch(PDO::FETCH_ASSOC);

$error = null;
$userRoles = explode(',', $_SESSION['user']['roles'] ?? '');
$isAdmin = in_array('admin', $userRoles);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['USER_ID'];
    if (empty($userId) || ($checkUserStmt = $pdo->prepare("SELECT 1 FROM emp_user WHERE EMP_ID = ?")) && $checkUserStmt->execute([$userId]) && $checkUserStmt->fetch()) {

        $oldData = json_encode([
            'OUTSTATION' => $printer['OUTSTATION'],
            'PRINTER_MODEL' => $printer['PRINTER_MODEL'],
            'CORRECT_SERIAL_NUMBER' => $printer['CORRECT_SERIAL_NUMBER'],
            'INVENTORY' => $printer['INVENTORY'],
            'WORKSTATION' => $printer['WORKSTATION'],
            'USER_NAME' => $printer['USER_NAME'],
            'FLOOR_NUMBER' => $printer['FLOOR_NUMBER'],
            'USER_ID' => $printer['USER_ID'],
            'VERIFIED' => $printer['VERIFIED']
        ]);

        $newVerified = $isAdmin ? (isset($_POST['VERIFIED']) ? 1 : 0) : $printer['VERIFIED'];

        $newData = json_encode([
            'OUTSTATION' => $_POST['OUTSTATION'],
            'PRINTER_MODEL' => $_POST['PRINTER_MODEL'],
            'CORRECT_SERIAL_NUMBER' => $_POST['CORRECT_SERIAL_NUMBER'],
            'INVENTORY' => $_POST['INVENTORY'],
            'WORKSTATION' => $_POST['WORKSTATION'],
            'USER_NAME' => $_POST['USER_NAME'],
            'FLOOR_NUMBER' => $_POST['FLOOR_NUMBER'],
            'USER_ID' => $_POST['USER_ID'],
            'VERIFIED' => $newVerified
        ]);

        $stmt = $pdo->prepare("UPDATE printer SET OUTSTATION=?, PRINTER_MODEL=?, CORRECT_SERIAL_NUMBER=?, INVENTORY=?, WORKSTATION=?, USER_NAME=?, FLOOR_NUMBER=?, USER_ID=?, VERIFIED=? WHERE id=?");
        $stmt->execute([
            $_POST['OUTSTATION'],
            $_POST['PRINTER_MODEL'],
            $_POST['CORRECT_SERIAL_NUMBER'],
            $_POST['INVENTORY'],
            $_POST['WORKSTATION'],
            $_POST['USER_NAME'],
            $_POST['FLOOR_NUMBER'],
            !empty($_POST['USER_ID']) ? $_POST['USER_ID'] : null,
            $newVerified,
            $id
        ]);

        $editedBy = $_SESSION['user']['username'] ?? 'unknown';
        $logStmt = $pdo->prepare("INSERT INTO printer_edit_log (printer_id, edited_by, edit_time, old_data, new_data) VALUES (?, ?, NOW(), ?, ?)");
        $logStmt->execute([$id, $editedBy, $oldData, $newData]);

        header('Location: printer_list.php');
        exit;
    } else {
        $error = "Invalid User ID: No matching employee found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Printer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 3% auto;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-container {
      display: grid;
      grid-template-columns: 1fr;
      gap: 15px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="checkbox"] {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .btn {
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      text-align: center;
    }

    .btn:hover {
      background: #0056b3;
    }

    .btn-group {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: center;
      grid-column: span 2;
    }

    .alert {
      background-color: #f8d7da;
      color: #721c24;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dropdown-results {
      border: 1px solid #ccc;
      max-height: 150px;
      overflow-y: auto;
      background-color: white;
      
      z-index: 9999;
      width: 100%;
      border-radius: 0 0 8px 8px;
    }

    .dropdown-results div {
      padding: 10px;
      cursor: pointer;
    }

    .dropdown-results div:hover {
      background-color: #f0f0f0;
    }

    @media screen and (min-width: 768px) {
      .form-container {
        grid-template-columns: repeat(2, 1fr);
      }

      .form-group.is-half {
        grid-column: span 1;
      }

      .form-group.is-full {
        grid-column: span 2;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Edit Printer</h2>
  <form method="post" autocomplete="off">
    <div class="form-container">
      <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php
      $fields = [
        'VENDOR_NAME' => true,
        'INVOICE_NO' => 'half',
        'BILL_DATE' => 'half',
        'SN' => true,
        'PRINTER_TYPE' => true,
        'PRINTER_SERIAL_NUMBER' => true,
        'OUTSTATION' => 'half',
        'PRINTER_MODEL' => 'half',
        'CORRECT_SERIAL_NUMBER' => false,
        'INVENTORY' => false,
        'WORKSTATION' => false,
        'USER_NAME' => false,
        'FLOOR_NUMBER' => false,
      ];

      foreach ($fields as $field => $setting):
        $isReadonly = $setting === true;
        $class = $setting === 'half' ? 'is-half' : 'is-full';
        $inputName = strtolower($field);
      ?>
        <div class="form-group <?= $class ?>">
          <label><?= str_replace("_", " ", $field) ?>:</label>
          <input type="text" name="<?= $field ?>" id="<?= $field ?>" value="<?= htmlspecialchars($printer[$field]) ?>" <?= $isReadonly ? 'disabled' : '' ?>>
        </div>
      <?php endforeach; ?>

      <div class="form-group is-full">
        <label for="USER_ID">User ID:</label>
        <input type="text" id="USER_ID" name="USER_ID" value="<?= htmlspecialchars($printer['USER_ID']) ?>">
        <div id="userDropdown" class="dropdown-results"></div>
      </div>

      <div class="checkbox-container">
        <label for="VERIFIED">Verified:</label>
        <input type="checkbox" id="VERIFIED" name="VERIFIED" <?= $printer['VERIFIED'] ? 'checked' : '' ?> <?= $isAdmin ? '' : 'disabled' ?>>
      </div>

      <div class="btn-group">
        <input type="submit" class="btn" value="Update Printer">
        <a class="btn" href="user_devices.php?user_id=<?= $printer['USER_ID'] ?>">User Devices</a>
      </div>
    </div>
  </form>
  <br>
  <a href="printer_log.php?id=<?= $id ?>">🔍 View Edit History</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const userIdInput = document.getElementById('USER_ID');
  const dropdown = document.getElementById('userDropdown');

  userIdInput.addEventListener('input', function () {
    const query = this.value.trim();
    dropdown.innerHTML = '';
    if (query.length < 2) return;

    fetch('search_user_ajax.php?q=' + encodeURIComponent(query))
      .then(res => res.json())
      .then(data => {
        dropdown.innerHTML = '';
        data.forEach(user => {
          const div = document.createElement('div');
          div.textContent = `${user.EMP_ID} - ${user.EMP_NAME} (${user.EMP_DESIGNATION})`;
          div.addEventListener('click', () => {
            userIdInput.value = user.EMP_ID;
            dropdown.innerHTML = '';
          });
          dropdown.appendChild(div);
        });
      })
      .catch(err => {
        console.error('Error fetching user:', err);
      });
  });
});
</script>

</body>
</html>
