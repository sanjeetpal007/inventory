<?php
include('phpqrcode/qrlib.php');

$qrFile = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data']) && !empty($_POST['filename'])) {
    $data = $_POST['data'];
    $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['filename']); // sanitize filename
    $outputDir = 'qrcodes_img/';

    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0777, true);
    }

    $qrFile = $outputDir . $filename . '.png';
    QRcode::png($data, $qrFile);
    $message = "QR Code generated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Generate QR Code</title>
</head>
<body>
  <h2>Generate QR Code</h2>
  <form method="POST">
    <label>Enter data (URL/text):</label><br>
    <input type="text" name="data" required><br><br>

    <label>Enter filename:</label><br>
    <input type="text" name="filename" required><br><br>

    <button type="submit">Generate QR Code</button>
  </form>

  <?php if ($qrFile): ?>
    <h3><?= $message ?></h3>
    <img src="<?= $qrFile ?>" alt="QR Code" style="margin-top:10px;"><br>
    <a href="<?= $qrFile ?>" download>⬇️ Download QR Code</a>
  <?php endif; ?>
</body>
</html>
