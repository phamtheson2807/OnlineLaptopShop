<?php
include '../../config/database.php';
session_start();

// Add error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $sql = "SELECT user_id, username, first_name, last_name FROM users WHERE is_admin = 0";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
    
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>