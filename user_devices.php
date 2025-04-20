<?php
session_start();
require 'db.php'; // loads $pdo

// ✅ Access control using session 'user' array
if (
    !isset($_SESSION['user']) ||
    strpos(strtolower($_SESSION['user']['roles']), 'admin') === false
) {
    echo "Access denied. You must be an admin to view this page.";
    exit;
}

// ✅ Get user_id from URL
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo "No user specified.";
    exit;
}

$target_user_id = $_GET['user_id'];

// ✅ Fetch emp_user details
$user_stmt = $pdo->prepare("SELECT * FROM emp_user WHERE EMP_ID = ?");
$user_stmt->execute([$target_user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}

// ✅ Fetch assigned PCs
$pc_stmt = $pdo->prepare("SELECT * FROM pc WHERE USER_ID = ?");
$pc_stmt->execute([$target_user_id]);
$pcs = $pc_stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Fetch assigned Printers
$printer_stmt = $pdo->prepare("SELECT * FROM printer WHERE USER_ID = ?");
$printer_stmt->execute([$target_user_id]);
$printers = $printer_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Devices Assigned to <?= htmlspecialchars($user['EMP_NAME']) ?> (<?= htmlspecialchars($target_user_id) ?>)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f8f9fa;
        }
        h1, h2 {
            color: #333;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 350px;
        }
        .card-item {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .card-item strong {
            display: inline-block;
            width: 140px;
            color: #555;
        }
        @media (max-width: 600px) {
            .card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Devices Assigned to <?= htmlspecialchars($user['EMP_NAME']) ?> (<?= htmlspecialchars($target_user_id) ?>)</h1>

    <h2>PCs</h2>
    <?php if (count($pcs) > 0): ?>
        <div class="card-container">
            <?php foreach ($pcs as $pc): ?>
                <div class="card">
                    <div class="card-item"><strong>ID:</strong> <?= htmlspecialchars($pc['id']) ?></div>
                    <div class="card-item"><strong>SN:</strong> <?= htmlspecialchars($pc['SN']) ?></div>
                    <div class="card-item"><strong>Model:</strong> <?= htmlspecialchars($pc['DESKTOP_PC_MODEL']) ?></div>
                    <div class="card-item"><strong>Serial Number:</strong> <?= htmlspecialchars($pc['CORRECT_SERIAL_NUMBER']) ?></div>
                    <div class="card-item"><strong>Workstation:</strong> <?= htmlspecialchars($pc['WORKSTATION']) ?></div>
                    <div class="card-item"><strong>Username:</strong> <?= htmlspecialchars($pc['USERNAME']) ?></div>
                    <div class="card-item"><strong>Floor Number:</strong> <?= htmlspecialchars($pc['FLOOR_NUMBER']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No PCs assigned to this user.</p>
    <?php endif; ?>

    <h2>Printers</h2>
    <?php if (count($printers) > 0): ?>
        <div class="card-container">
            <?php foreach ($printers as $printer): ?>
                <div class="card">
                    <div class="card-item"><strong>ID:</strong> <?= htmlspecialchars($printer['id']) ?></div>
                    <div class="card-item"><strong>SN:</strong> <?= htmlspecialchars($printer['SN']) ?></div>
                    <div class="card-item"><strong>Model:</strong> <?= htmlspecialchars($printer['PRINTER_MODEL']) ?></div>
                    <div class="card-item"><strong>Serial Number:</strong> <?= htmlspecialchars($printer['CORRECT_SERIAL_NUMBER']) ?></div>
                    <div class="card-item"><strong>Workstation:</strong> <?= htmlspecialchars($printer['WORKSTATION']) ?></div>
                    <div class="card-item"><strong>Username:</strong> <?= htmlspecialchars($printer['USER_NAME']) ?></div>
                    <div class="card-item"><strong>Floor Number:</strong> <?= htmlspecialchars($printer['FLOOR_NUMBER']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No printers assigned to this user.</p>
    <?php endif; ?>
</body>
</html>
