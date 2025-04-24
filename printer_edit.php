<?php
include 'auth.php';
include 'db.php';
include('phpqrcode/qrlib.php');





checkAuth(['admin', 'user']);

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM printer WHERE id = ?");
$stmt->execute([$id]);
$printer = $stmt->fetch(PDO::FETCH_ASSOC);

$error = null;
$userRoles = explode(',', $_SESSION['user']['roles'] ?? '');
$isAdmin = in_array('admin', $userRoles);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	
	
	
	
	
	// qr file saving in local storage
	$id_qr = $_GET['id'];
	$data = 'sanjeetpal.co.in';
	//$filename = 'filename_'.$id_qr.$printer['PRINTER_SERIAL_NUMBER']; // sanitize filename
    $filename = 'printer_'.$id_qr;
	$outputDir='qrcodes_img/printer/';

    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0777, true);
    }
    $qrFile = $outputDir . $filename . '.png';
	//$qrFile = 'qrcodes_img/qrcode.png';
	// QR Code parameters
	$matrixPointSize = 5.75; // Size of each module (1-10), adjust this to get approx. 120x120
	$margin = 0;           // White border

	QRcode::png($data, $qrFile, QR_ECLEVEL_L, $matrixPointSize, $margin);
	
	//QRcode::png($data, $qrFile);
	
	// Optional: Resize to exact 120x120 using GD (if the QR output is slightly off)
	//$image = imagecreatefrompng($qrFile);
	//$resized = imagescale($image, 120, 120);
	//imagepng($resized, $qrFile); // Overwrite original
	//imagedestroy($image);
	//imagedestroy($resized);
	
	
	
	
	
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
      margin: 1%;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="checkbox"],
    select {
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
	@media screen and (max-width: 768px) {
		.form-container {
			display:unset;
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
      ];

      foreach ($fields as $field => $setting):
        $isReadonly = $setting === true;
        $class = $setting === 'half' ? 'is-half' : 'is-full';
      ?>
        <div class="form-group <?= $class ?>">
          <label><?= str_replace("_", " ", $field) ?>:</label>
          <input type="text" name="<?= $field ?>" id="<?= $field ?>" value="<?= htmlspecialchars($printer[$field]) ?>" <?= $isReadonly ? 'disabled' : '' ?>>
        </div>
      <?php endforeach; ?>

      <!-- FLOOR_NUMBER Dropdown -->
      <div class="form-group is-full">
        <label for="FLOOR_NUMBER">Floor Number:</label>
        <select name="FLOOR_NUMBER" id="FLOOR_NUMBER">
          <?php
          $floors = ['NA','Ground', 'Lobby', '1st Floor', '2nd Floor', '3rd Floor', '4th Floor', '5th Floor', '6th Floor', '7th Floor'];
          foreach ($floors as $floor) {
            $selected = ($printer['FLOOR_NUMBER'] === $floor) ? 'selected' : '';
            echo "<option value=\"$floor\" $selected>$floor</option>";
          }
          ?>
        </select>
      </div>

      <!-- USER_ID field -->
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
		$filename='printer_'.$id_qr;
		$qrCodePath = 'qrcodes_img/printer/' . $filename . '.png'; // Path to the QR code image
		$logoPath = 'qrcodes_img/logo.png'; // Path to the company logo
		$employeeId = $printer['USER_ID'].'('.$printer['ID'].')';
		/* $stmt = $pdo->prepare("SELECT EMP_NAME FROM emp_user WHERE EMP_ID = ?");
		$stmt->execute([$employeeId]);
		$empinfo = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($empinfo) {
			$employeeName = $empinfo['EMP_NAME'];
		} else {
			$employeeName = 'Unknown';
		}*/

		
		
		//$empinfo = $pdo->query("SELECT 1 FROM emp_user WHERE EMP_ID = ".$employeeId)->fetchAll(PDO::FETCH_ASSOC);
		
		
		$employeeName = $printer['USER_NAME'];
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
		<div id="qr_body" style="display: inherit;">

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
