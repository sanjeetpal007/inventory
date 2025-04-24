<?php
include 'auth.php';
include 'db.php';
include('phpqrcode/qrlib.php');
checkAuth(['admin', 'user']); // Allow both admin and user

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM pc WHERE id = ?");
$stmt->execute([$id]);
$pc = $stmt->fetch(PDO::FETCH_ASSOC);

$error = null;
$userRoles = explode(',', $_SESSION['user']['roles'] ?? '');
$isAdmin = in_array('admin', $userRoles);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	
	
	
	// qr file saving in local storage
	$id_qr = $_GET['id'];
	$data = 'sanjeetpal.co.in';
	//$filename = 'filename_'.$id_qr.$pc['PC_SERIAL_NUMBER']; // sanitize filename
    $filename = 'pc_'.$id_qr;
	$outputDir='qrcodes_img/pc/';

    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0777, true);
    }
    $qrFile = $outputDir . $filename . '.png';
	//$qrFile = 'qrcodes_img/qrcode.png';
	$matrixPointSize = 5.75; // Size of each module (1-10), adjust this to get approx. 120x120
	$margin = 0;           // White border

	QRcode::png($data, $qrFile, QR_ECLEVEL_L, $matrixPointSize, $margin);
	
	
	
	
	
	
	
	
    $userId = $_POST['USER_ID'];
    if (empty($userId) || ($checkUserStmt = $pdo->prepare("SELECT 1 FROM emp_user WHERE EMP_ID = ?")) && $checkUserStmt->execute([$userId]) && $checkUserStmt->fetch()) {
        $oldData = json_encode([
            'OUTSTATION' => $pc['OUTSTATION'],
            'DESKTOP_PC_MODEL' => $pc['DESKTOP_PC_MODEL'],
            'CORRECT_SERIAL_NUMBER' => $pc['CORRECT_SERIAL_NUMBER'],
            'INVENTORY' => $pc['INVENTORY'],
            'WORKSTATION' => $pc['WORKSTATION'],
            'USERNAME' => $pc['USERNAME'],
            'FLOOR_NUMBER' => $pc['FLOOR_NUMBER'],
            'USER_ID' => $pc['USER_ID'],
            'VERIFIED' => $pc['VERIFIED']
        ]);

        $newVerified = $isAdmin ? (isset($_POST['VERIFIED']) ? 1 : 0) : $pc['VERIFIED'];

        $newData = json_encode([
            'OUTSTATION' => $_POST['OUTSTATION'],
            'DESKTOP_PC_MODEL' => $pc['DESKTOP_PC_MODEL'], // keep old value
            'CORRECT_SERIAL_NUMBER' => $_POST['CORRECT_SERIAL_NUMBER'],
            'INVENTORY' => $_POST['INVENTORY'],
            'WORKSTATION' => $_POST['WORKSTATION'],
            'USERNAME' => $_POST['USERNAME'],
            'FLOOR_NUMBER' => $_POST['FLOOR_NUMBER'],
            'USER_ID' => $_POST['USER_ID'],
            'VERIFIED' => $newVerified
        ]);

        $stmt = $pdo->prepare("UPDATE pc SET OUTSTATION=?, DESKTOP_PC_MODEL=?, CORRECT_SERIAL_NUMBER=?, INVENTORY=?, WORKSTATION=?, USERNAME=?, FLOOR_NUMBER=?, USER_ID=?, VERIFIED=? WHERE id=?");
        $stmt->execute([
            $_POST['OUTSTATION'],
            $pc['DESKTOP_PC_MODEL'], // keep the same value
            $_POST['CORRECT_SERIAL_NUMBER'],
            $_POST['INVENTORY'],
            $_POST['WORKSTATION'],
            $_POST['USERNAME'],
            $_POST['FLOOR_NUMBER'],
            !empty($_POST['USER_ID']) ? $_POST['USER_ID'] : null,
            $newVerified, $id
        ]);

        $editedBy = $_SESSION['user']['username'] ?? 'unknown';
        $logStmt = $pdo->prepare("INSERT INTO pc_edit_log (pc_id, edited_by, edit_time, old_data, new_data) VALUES (?, ?, NOW(), ?, ?)");
        $logStmt->execute([$id, $editedBy, $oldData, $newData]);

        header('Location: pc_list.php');
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
  <title>Edit PC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/inventory.css">
  <style>
    .dropdown-results {
      border: 1px solid #ccc;
      max-height: 150px;
      overflow-y: auto;
      background-color: white;
      z-index: 9999;
      width: calc(100% - 20px);
    }

    .dropdown-results div {
      padding: 5px 10px;
      cursor: pointer;
    }

    .dropdown-results div:hover {
      background-color: #f0f0f0;
    }

    .btn-small {
      padding: 4px 8px;
      font-size: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 12px 18px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-container label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
      color: #333;
    }

    .form-container input[type="text"],
    .form-container input[type="checkbox"],
    .form-container select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    .alert {
      background-color: #f8d7da;
      color: #721c24;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .container {
      margin: 3%;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn {
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      margin-top: 15px;
    }

    .btn:hover {
      background: #0056b3;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .half-field-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 10px;
    }

    .half-field {
      flex: 1 1 calc(50% - 5px);
    }
	@media screen and (max-width: 768px) { 
		.half-field {
		  flex: 1 1 calc(100% - 5px);
		}
	
	}
  </style>
</head>
<body>

<div class="container">
  <h2>Edit PC</h2>
  <div class="form-container">
    <?php if ($error): ?>
      <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
      <!-- Half-span fields -->
      <div class="half-field-wrapper">
        <div class="half-field">
          <label>INVOICE NO:</label>
          <input type="text" value="<?= htmlspecialchars($pc['INVOICE_NO']) ?>" disabled>
        </div>
        <div class="half-field">
          <label>BILL DATE:</label>
          <input type="text" value="<?= htmlspecialchars($pc['BILL_DATE']) ?>" disabled>
        </div>
      </div>

      <div class="half-field-wrapper">
        <div class="half-field">
          <label for="OUTSTATION">OUTSTATION:</label>
          <input type="text" id="OUTSTATION" name="OUTSTATION" value="<?= htmlspecialchars($pc['OUTSTATION']) ?>">
        </div>
        <div class="half-field">
          <label>DESKTOP PC MODEL:</label>
          <input type="text" value="<?= htmlspecialchars($pc['DESKTOP_PC_MODEL']) ?>" disabled>
        </div>
      </div>

      <div class="half-field-wrapper">
        <div class="half-field">
          <label>RAM SIZE:</label>
          <input type="text" value="<?= htmlspecialchars($pc['RAM_SIZE']) ?>" disabled>
        </div>
        <div class="half-field">
          <label>ROM SIZE:</label>
          <input type="text" value="<?= htmlspecialchars($pc['ROM_SIZE']) ?>" disabled>
        </div>
      </div>

      <?php
      $readonlyFields = ['VENDOR_NAME', 'SN', 'PC_SERIAL_NUMBER'];
      foreach ($readonlyFields as $field):
      ?>
        <label><?= str_replace("_", " ", $field) ?>:</label>
        <input type="text" value="<?= htmlspecialchars($pc[$field]) ?>" disabled><br>
      <?php endforeach; ?>

      <?php
      $editableFields = ['CORRECT_SERIAL_NUMBER', 'INVENTORY', 'WORKSTATION', 'USERNAME'];
      foreach ($editableFields as $field):
      ?>
        <label for="<?= $field ?>"><?= str_replace("_", " ", $field) ?>:</label>
        <input type="text" id="<?= $field ?>" name="<?= $field ?>" value="<?= htmlspecialchars($pc[$field]) ?>"><br>
      <?php endforeach; ?>

      <!-- Dropdown for FLOOR NUMBER -->
      <label for="FLOOR_NUMBER">FLOOR NUMBER:</label>
      <select name="FLOOR_NUMBER" id="FLOOR_NUMBER">
        <?php
        $floors = ['NA','GROUND', 'LOBBY', '1st FLOOR', '2nd FLOOR', '3rd FLOOR', '4th FLOOR', '5th FLOOR', '6th FLOOR', '7th FLOOR'];
        foreach ($floors as $floor):
          $selected = ($pc['FLOOR_NUMBER'] === $floor) ? 'selected' : '';
          echo "<option value=\"$floor\" $selected>$floor</option>";
        endforeach;
        ?>
      </select><br>

      <label for="USER_ID">User ID:</label>
      <input type="text" id="USER_ID" name="USER_ID" value="<?= htmlspecialchars($pc['USER_ID']) ?>">
      <div id="userDropdown" class="dropdown-results"></div><br>

      <div class="checkbox-container">
        <label for="VERIFIED">Verified:</label>
        <input type="checkbox" id="VERIFIED" name="VERIFIED" <?= $pc['VERIFIED'] ? 'checked' : '' ?> <?= $isAdmin ? '' : 'disabled' ?> style="height: 30px; width: 50%;">
      </div>

      <div class="btn-group">
        <input type="submit" class="btn" value="Update PC">
        <a class="btn btn-small" href="user_devices.php?user_id=<?= $pc['USER_ID'] ?>">User Devices</a>
		
<!-- qr printering code start here -->
		
		<!-- first try
		<?php
		//$id_qr = $_GET['id'];
		//$filename = 'printer_'.$id_qr;
		//$outputDir='qrcodes_img/printer/';

    
		//$qrFile = 'qrcodes_img/printer/' . $filename . '.png';
		//$imagePath = 'qrcodes_img/printer/filename_.png'; // change this path as needed
		?>
		
		<a class=" btn" onclick="printImage()">Print QR Code</a>
		<iframe id="printFrame" src="" style="display: none;"></iframe>
		<script>
			function printImage() {
				const imageURL = '<?php //echo $qrFile; ?>';
				const printFrame = document.getElementById('printFrame');
				const serial_num = '<?php //echo $printer['PRINTER_SERIAL_NUMBER']; ?>';
				const doc = printFrame.contentWindow.document;
				doc.open();
				doc.write('<html><head><title>Print</title></head><body onload="window.print();window.close();" style="display:flex;">');
				doc.write('<img src="' + imageURL + '" style="width: 50%; height: 40%;">');
				doc.write('<h2 style="margin-top: 5%;width: 40%;font-size: 150%; margin-top: 10%;">'+ serial_num +'</h2></body></html>');
				doc.close();
			}
		</script> -->
		<?php
		$id_qr=$_GET['id'];
		$filename='pc_'.$id_qr;
		$qrCodePath = 'qrcodes_img/pc/' . $filename . '.png'; // Path to the QR code image
		$logoPath = 'qrcodes_img/logo.png'; // Path to the company logo
		$employeeId = $pc['USER_ID'].'('.$pc['ID'].')';
		/* $stmt = $pdo->prepare("SELECT EMP_NAME FROM emp_user WHERE EMP_ID = ?");
		$stmt->execute([$employeeId]);
		$empinfo = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($empinfo) {
			$employeeName = $empinfo['EMP_NAME'];
		} else {
			$employeeName = 'Unknown';
		}*/

		
		
		//$empinfo = $pdo->query("SELECT 1 FROM emp_user WHERE EMP_ID = ".$employeeId)->fetchAll(PDO::FETCH_ASSOC);
		
		
		$employeeName = $pc['USERNAME'];
		?>

		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Print QR Code Layout</title>
			<style>
				#qr_div {
					font-family: Arial, sans-serif;
					text-align: center;
					margin-top: 40px;
				}

				.container_qr {
					display: flex;
					justify-content: space-between;
					align-items: center;
					border: 1px solid #ccc;
					padding: 10px;
					margin: 0 auto;
					width: 3.5in;
					height: 1.4in;
					box-sizing: border-box;
					display:none;
				}

				.left, .right {
					flex: 1;
					text-align: center;
				}

				.left img {
					max-width: 100%;
					max-height: 100%;
				}

				.right .label {
					font-weight: bold;
					margin-bottom: 5px;
				}

				.right img {
					max-width: 80px;
					height: auto;
					margin-bottom: 5px;
				}

				.right .id {
					font-weight: bold;
					margin-bottom: 3px;
				}

				a #button_qr{
					margin-top: 20px;
					padding: 10px 20px;
					font-size: 1em;
					cursor: pointer;
				}
			</style>
		</head>
		<div id="qr_body" style="display: inline;">

			<!--<h2>Print QR Code</h2>-->
			<div class="container_qr" id="printArea">
				<div class="left" style="width: 120px;height: 120px;">
					<img src="<?php echo $qrCodePath; ?>" style="width: 124px;" alt="QR Code">
				</div>
				<div class="right">
					<!-- <div class="label">IMAGE</div> -->
					<img src="<?php echo $logoPath; ?>" alt="Company Logo">
					<div class="id"><?php echo $employeeId; ?></div>
					<div><?php echo $employeeName; ?></div>
				</div>
			</div>

		<a id="button_qr" class="btn" onclick="printImage()">Print QR Code</a>

		<script>
			function printImage() {
				const content = document.getElementById("printArea").outerHTML;

				const iframe = document.createElement("iframe");
				iframe.style.position = "fixed";
				iframe.style.right = "0";
				iframe.style.bottom = "0";
				iframe.style.width = "0";
				iframe.style.height = "0";
				iframe.style.border = "none";
				document.body.appendChild(iframe);

				const doc = iframe.contentDocument || iframe.contentWindow.document;
				doc.open();
				doc.write(`
					<!DOCTYPE html>
					<html>
					<head>
						<title>Print</title>
						<style>
							@page {
								size: 3.5in 1.4in landscape;
								margin: 0;
							}
							#qr_body {
								font-family: Arial, sans-serif;
								
							}
							.container_qr {
								display: flex;
								justify-content: space-between;
								align-items: center;
								width: 3.5in;
								height: 1.4in;
								padding: 10px;
								box-sizing: border-box;
							}
							.left, .right {
								flex: 1;
								text-align: center;
							}
							.left img {
								max-width: 100%;
								max-height: 100%;
							}
							.right .label {
								font-weight: bold;
								margin-bottom: 5px;
							}
							.right img {
								max-width: 80px;
								height: auto;
								margin-bottom: 5px;
							}
							.right .id {
								font-weight: bold;
								margin-bottom: 3px;
							}
						</style>
					</head>
					<div>
						${content}
					</div>
					</html>
				`);
				doc.close();

				iframe.onload = function () {
					iframe.contentWindow.focus();
					iframe.contentWindow.print();

					setTimeout(() => {
						document.body.removeChild(iframe);
					}, 1000);
				};
			}
		</script>

		</div>
		
		
		
		
		
<!--qr printing code end here -->
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
      </div>
	
    </form>
    <br>
    <a href="pc_log.php?id=<?= $id ?>">🔍 View Edit History</a>
  </div>
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
