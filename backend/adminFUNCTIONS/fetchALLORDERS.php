<?php
include '../../config/database.php';

$sql = "SELECT ao.*, u.username, u.email, u.location, o.status, o.payment_option, o.carrier, p.name as product_name 
        FROM allorder ao
        JOIN users u ON ao.user_id = u.user_id
        JOIN orders o ON ao.order_id = o.order_id
        JOIN products p ON ao.product_id = p.product_id
        ORDER BY ao.all_order_id DESC";

$result = $conn->query($sql);
$orders = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode($orders);
$conn->close();
?>