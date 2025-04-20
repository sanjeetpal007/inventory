<?php
// index.php - Home Page (authenticated only)
include 'auth.php';
checkAuth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <style>
    #qrModal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }

    #qrScanner {
      width: 90%;
      max-width: 400px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
    }

    #qrScanner button {
      margin-top: 15px;
      background-color: #dc3545;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
  </style>

  <!-- QR Scanner Library -->
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>

<div class="container">
  <h1>📦 Inventory Management Home</h1>
  <p class="user-info">
    You are logged in as <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong><br>
    Roles: <strong><?= htmlspecialchars($_SESSION['user']['roles']) ?></strong>
  </p>

  <div class="btn-group">
    <a class="btn" id="qrBtn">📷 Scan QR Code</a>
    <a class="btn" href="dashboard.php">📊 Dashboard</a>
    <a class="btn danger" href="logout.php">🚪 Logout</a>
  </div>

  <hr>

  <h2>🖥️ PC Management</h2>
  <ul class="pc-links">
    <li><a href="pc_list.php">📋 View All PCs</a></li>
    <li><a href="pc_add.php">➕ Add New PC</a></li>
  </ul>
</div>

<!-- QR Scanner Modal -->
<div id="qrModal">
  <div id="qrScanner">
    <div id="reader" style="width: 100%;"></div>
    <button onclick="stopQR()">Cancel</button>
  </div>
</div>
<script>
  const qrBtn = document.getElementById('qrBtn');
  const qrModal = document.getElementById('qrModal');
  let html5QrCode;

  qrBtn.addEventListener('click', () => {
    qrModal.style.display = 'flex';

    html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {
      if (devices && devices.length) {
        html5QrCode.start(
          { facingMode: "environment" }, // use back camera
          { fps: 10, qrbox: 250 },
          qrCodeMessage => {
            html5QrCode.stop().then(() => {
              qrModal.style.display = 'none';

              // Uncomment below line to auto open scanned URL:
              // window.location.href = qrCodeMessage;

              // Open scanned URL in a new tab without encoding (handles full URLs with ://)
              if (qrCodeMessage.startsWith("http://") || qrCodeMessage.startsWith("https://")) {
                window.open(qrCodeMessage, '_blank');
              } else {
                alert("Scanned content is not a valid URL:\n" + qrCodeMessage);
              }

            });
          },
          errorMessage => {
            // console.warn(`QR error: ${errorMessage}`);
          }
        ).catch(err => {
          alert("Unable to start scanner: " + err);
        });
      }
    }).catch(err => {
      alert("Camera error: " + err);
    });
  });

  function stopQR() {
    if (html5QrCode) {
      html5QrCode.stop().then(() => {
        qrModal.style.display = 'none';
      }).catch(err => {
        console.error("Failed to stop QR scanner", err);
      });
    } else {
      qrModal.style.display = 'none';
    }
  }
</script>


</body>
</html>
