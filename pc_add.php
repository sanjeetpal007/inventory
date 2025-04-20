<?php
include 'auth.php';
include 'db.php';
checkAuth('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkUser = $pdo->prepare("SELECT EMP_ID FROM emp_user WHERE EMP_ID = ?");
    $checkUser->execute([$_POST['USER_ID']]);

    if ($checkUser->rowCount() === 0) {
        echo "<script>
            alert('❌ Error: USER ID \"{$_POST['USER_ID']}\" does not exist.');
            window.history.back();
        </script>";
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO pc (
            VENDOR_NAME, INVOICE_NO, BILL_DATE, SN, OUTSTATION,
            DESKTOP_PC_MODEL, RAM_SIZE, ROM_SIZE, PC_SERIAL_NUMBER,
            CORRECT_SERIAL_NUMBER, INVENTORY, WORKSTATION, USERNAME,
            FLOOR_NUMBER, USER_ID
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $_POST['VENDOR_NAME'], $_POST['INVOICE_NO'], $_POST['BILL_DATE'], $_POST['SN'],
            $_POST['OUTSTATION'], $_POST['DESKTOP_PC_MODEL'], $_POST['RAM_SIZE'], $_POST['ROM_SIZE'],
            $_POST['PC_SERIAL_NUMBER'], $_POST['CORRECT_SERIAL_NUMBER'], $_POST['INVENTORY'],
            $_POST['WORKSTATION'], $_POST['USERNAME'], $_POST['FLOOR_NUMBER'], $_POST['USER_ID']
        ]);

        echo "<script>
            alert('✅ PC added successfully!');
            window.location.href = 'pc_list.php';
        </script>";
        exit();
    } catch (PDOException $e) {
        echo "<script>
            alert('❌ Unexpected error while saving the PC.');
            window.history.back();
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add PC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 1rem;
      background: #f7f9fc;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    label {
      font-weight: bold;
      margin-bottom: 0.2rem;
    }

    .form-group {
      flex: 1 1 100%;
      display: flex;
      flex-direction: column;
    }

    input[type="text"], input[type="date"] {
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    input[type="submit"] {
      padding: 0.7rem 1.5rem;
      background: #007BFF;
      color: white;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      align-self: flex-start;
    }

    input[type="submit"]:hover {
      background: #0056b3;
    }

    #suggestions {
      border: 1px solid #ccc;
      max-height: 150px;
      overflow-y: auto;
      background: white;
      z-index: 1000;
      width: 100%;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    #suggestions div {
      padding: 8px;
      cursor: pointer;
    }

    #suggestions div:hover {
      background-color: #f0f0f0;
    }

    @media (min-width: 600px) {
      .form-group.half {
        flex: 1 1 48%;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Add New PC</h2>
  <form id="pcAddForm" method="POST">
    <?php
      $fields = [
        'VENDOR_NAME', 'INVOICE_NO', 'BILL_DATE', 'SN', 'OUTSTATION',
        'DESKTOP_PC_MODEL', 'RAM_SIZE', 'ROM_SIZE', 'PC_SERIAL_NUMBER',
        'CORRECT_SERIAL_NUMBER', 'INVENTORY', 'WORKSTATION', 'USERNAME',
        'FLOOR_NUMBER', 'USER_ID'
      ];
      $requiredFields = [
        'VENDOR_NAME', 'INVOICE_NO', 'BILL_DATE', 'SN', 'OUTSTATION',
        'DESKTOP_PC_MODEL', 'RAM_SIZE', 'ROM_SIZE', 'PC_SERIAL_NUMBER', 'USER_ID'
      ];
      foreach ($fields as $field):
        $isRequired = in_array($field, $requiredFields) ? 'required' : '';
        $isHalf = in_array($field, ['RAM_SIZE', 'ROM_SIZE', 'INVOICE_NO', 'BILL_DATE','OUTSTATION','DESKTOP_PC_MODEL' ,'FLOOR_NUMBER']) ? 'half' : '';
    ?>
      <div class="form-group <?= $isHalf ?>">
        <label for="<?= $field ?>"><?= str_replace("_", " ", $field) ?>:</label>
        <input type="<?= $field === 'BILL_DATE' ? 'date' : 'text' ?>" id="<?= $field ?>" name="<?= $field ?>" <?= $isRequired ?>>
        <?php if ($field === 'USER_ID'): ?>
          <div id="suggestions"></div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <input type="submit" value="Add PC">
  </form>
</div>

<script>
  const userIdInput = document.getElementById('USER_ID');
  const suggestionsBox = document.getElementById('suggestions');

  userIdInput.addEventListener('input', () => {
    const query = userIdInput.value.trim();
    if (query.length < 2) {
      suggestionsBox.innerHTML = '';
      suggestionsBox.style.display = 'none';
      return;
    }

    fetch('search_user_ajax.php?q=' + encodeURIComponent(query))
      .then(res => res.text())
      .then(text => {
        try {
          const data = JSON.parse(text);
          suggestionsBox.innerHTML = '';
          if (data.length > 0) {
            suggestionsBox.style.display = 'block';
            data.forEach(user => {
              const div = document.createElement('div');
              div.textContent = `${user.EMP_ID} - ${user.EMP_NAME} (${user.EMP_DEPT}, ${user.EMP_DESIGNATION})`;
              div.addEventListener('click', () => {
                userIdInput.value = user.EMP_ID;
                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
              });
              suggestionsBox.appendChild(div);
            });
          } else {
            suggestionsBox.style.display = 'none';
          }
        } catch (err) {
          console.error("Invalid JSON:", text);
        }
      });
  });

  document.addEventListener('click', function(e) {
    if (!suggestionsBox.contains(e.target) && e.target !== userIdInput) {
      suggestionsBox.style.display = 'none';
    }
  });
</script>

</body>
</html>
