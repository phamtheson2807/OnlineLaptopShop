<?php
session_start();
include '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Remove item from cart
    $delete_sql = "DELETE FROM Cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove item from cart']);
    }

    $stmt->close();
    $conn->close();
}
?>