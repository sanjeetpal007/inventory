<?php
include 'auth.php';
include 'db.php';
checkAuth('admin');

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: pc_list.php");
    exit;
}

// Fetch PC data before clearing fields for logging
$stmt = $pdo->prepare("SELECT * FROM pc WHERE id = ?");
$stmt->execute([$id]);
$pc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pc) {
    echo "PC not found.";
    exit;
}

$oldData = json_encode($pc);
$deletedBy = $_SESSION['user']['username'] ?? 'unknown';

// Mark fields as DELETED
$updateStmt = $pdo->prepare("
    UPDATE pc 
    SET workstation = 'DELETED', 
        username = 'DELETED', 
        floor_number = 'DELETED', 
        user_id = 'DELETED' 
    WHERE id = ?
");
$updateStmt->execute([$id]);

// Prepare new data for logging
$updatedPc = $pc;
$updatedPc['workstation'] = 'DELETED';
$updatedPc['username'] = 'DELETED';
$updatedPc['floor_number'] = 'DELETED';
$updatedPc['user_id'] = 'DELETED';
$newData = json_encode($updatedPc);

// Log the update
$logStmt = $pdo->prepare("
    INSERT INTO pc_edit_log (pc_id, edited_by, edit_time, old_data, new_data) 
    VALUES (?, ?, NOW(), ?, ?)
");
$logStmt->execute([$id, $deletedBy, $oldData, $newData]);

// Redirect to PC list
header("Location: pc_list.php");
exit;
?>
