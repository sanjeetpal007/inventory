<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$q = $_GET['q'] ?? '';
if ($q === '') {
    echo json_encode([]);
    exit;
}

try {
    $sql = "SELECT EMP_ID, EMP_NAME, EMP_ACTIVE, EMP_SCALE, EMP_DESIG, EMP_DESIGNATION, EMP_DEPT 
            FROM emp_user 
            WHERE 
                EMP_ID LIKE ? OR 
                EMP_NAME LIKE ? OR 
                EMP_ACTIVE LIKE ? OR 
                EMP_SCALE LIKE ? OR 
                EMP_DESIG LIKE ? OR 
                EMP_DESIGNATION LIKE ? OR 
                EMP_DEPT LIKE ?
            LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%" . $q . "%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
