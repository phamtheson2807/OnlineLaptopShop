<?php
session_start();
include '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $change = $_POST['change'];

    // Check if item exists in cart
    $check_sql = "SELECT quantity FROM Cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $change;

        if ($new_quantity > 0) {
            // Update quantity if new quantity is greater than 0
            $update_sql = "UPDATE Cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Quantity updated successfully']);
        } else {
            // Remove item if new quantity is 0 or less
            $delete_sql = "DELETE FROM Cart WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found in cart']);
    }

    $stmt->close();
    $conn->close();
}
?>