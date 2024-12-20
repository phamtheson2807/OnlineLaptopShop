<?php
session_start();
include '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = 1; // Default quantity

    // Check if item already exists in cart
    $check_sql = "SELECT * FROM Cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update quantity if item exists
        $sql = "UPDATE Cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
    } else {
        // Insert new item if it doesn't exist
        $sql = "INSERT INTO Cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    }

    $stmt = $conn->prepare($sql);
    if ($result->num_rows > 0) {
        $stmt->bind_param("ii", $user_id, $product_id);
    } else {
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Added to cart successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add to cart']);
    }

    $stmt->close();
    $conn->close();
}
?>