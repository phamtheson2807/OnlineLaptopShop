<?php
include '../../config/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$sql = "SELECT r.return_id, r.reason, r.image_path, r.status, r.created_at, 
        u.username, p.name as product_name, u.location, o.carrier
        FROM returns r
        JOIN users u ON r.user_id = u.user_id
        JOIN orders o ON r.order_id = o.order_id
        JOIN products p ON o.product_id = p.product_id
        ORDER BY r.created_at DESC";

$result = $conn->query($sql);
$returns = [];

while($row = $result->fetch_assoc()) {
    $returns[] = [
        'return_id' => $row['return_id'],
        'username' => $row['username'],
        'product_name' => $row['product_name'],
        'reason' => $row['reason'],
        'image_path' => $row['image_path'],
        'status' => $row['status'],
        'created_at' => $row['created_at'],
        'location' => $row['location'],
        'carrier' => $row['carrier']
    ];
}

echo json_encode(['returns' => $returns]);
$conn->close();
?>