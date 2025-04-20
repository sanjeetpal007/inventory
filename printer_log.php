<?php
include 'auth.php';
include 'db.php';
checkAuth('admin');

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM printer_edit_log WHERE printer_id = ? ORDER BY edit_time DESC");
$stmt->execute([$id]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/dashboard.css"> <!-- or inventory.css or auth.css -->
<script src="js/main.js"></script>
<script src="js/form-validation.js"></script>
<script src="js/dashboard.js"></script> <!-- only where needed -->


<h2>Printer Edit History</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Edited By</th>
        <th>Edit Time</th>
        <th>Field</th>
        <th>Old Value</th>
        <th>New Value</th>
    </tr>
    <?php foreach ($logs as $log): ?>
        <?php
        $old = json_decode($log['old_data'], true) ?: [];
        $new = json_decode($log['new_data'], true) ?: [];
        foreach ($old as $key => $oldVal):
            $newVal = isset($new[$key]) ? $new[$key] : null;
            if ($oldVal != $newVal):
        ?>
            <tr>
                <td><?= htmlspecialchars($log['edited_by']) ?></td>
                <td><?= htmlspecialchars($log['edit_time']) ?></td>
                <td><?= htmlspecialchars($key) ?></td>
                <td><?= htmlspecialchars($oldVal) ?></td>
                <td><?= htmlspecialchars($newVal) ?></td>
            </tr>
        <?php
            endif;
        endforeach;
        ?>
    <?php endforeach; ?>
</table>
<br>
<a href="printer_list.php">⬅️ Back to Printer List</a>