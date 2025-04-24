<?php
include 'auth.php';
include 'db.php';
include('phpqrcode/qrlib.php');

try {
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM pc");

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=pc_export_all.csv');

    $output = fopen('php://output', 'w');

    $first = true;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($first) {
            fputcsv($output, array_keys($row));
            $first = false;
        }
        fputcsv($output, $row);
    }

    fclose($output);
    exit;

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
