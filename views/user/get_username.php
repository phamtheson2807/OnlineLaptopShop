<?php
session_start();
include '../../config/database.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if($result && $row = mysqli_fetch_assoc($result)) {
    $_SESSION['username'] = $row['username']; // Update session
    echo json_encode([
        'success' => true,
        'username' => $row['username']
    ]);
} else {
    echo json_encode([
        'success' => false
    ]);
}
?>