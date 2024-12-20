<?php
session_start();
include '../../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Join Cart and Products tables to get complete item details
$sql = "SELECT c.cart_id, c.quantity, c.product_id, 
        p.name, p.price, p.image_url, p.stock 
        FROM Cart c 
        JOIN Products p ON c.product_id = p.product_id 
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = [
        'cart_id' => $row['cart_id'],
        'product_id' => $row['product_id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'image_url' => $row['image_url'],
        'stock' => $row['stock']
    ];
}

header('Content-Type: application/json');
echo json_encode($cart_items);

$stmt->close();
$conn->close();
?>