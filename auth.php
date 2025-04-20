<?php
// auth.php - User authentication & role check
session_start();

function checkAuth($roles = null) {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    // If roles are specified, check if user has at least one of them
    if ($roles) {
        $userRoles = explode(',', $_SESSION['user']['roles']); // 'admin,user' → ['admin', 'user']
        $requiredRoles = is_array($roles) ? $roles : [$roles];  // Normalize input to array

        $hasRole = false;
        foreach ($requiredRoles as $role) {
            if (in_array($role, $userRoles)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            echo "Access denied.";
            exit();
        }
    }
}
?>
