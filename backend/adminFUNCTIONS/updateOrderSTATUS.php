<?php
session_start();
include '../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        // Update Orders table
        $orders_sql = "UPDATE Orders SET status = ? WHERE order_id = ?";
        $orders_stmt = $conn->prepare($orders_sql);
        $orders_stmt->bind_param("si", $status, $order_id);

        if ($orders_stmt->execute()) {
            // If status is "Return complete", delete from returns table
            if ($status === "Return Complete") {
                $returns_sql = "DELETE FROM returns WHERE order_id = ?";
                $returns_stmt = $conn->prepare($returns_sql);
                $returns_stmt->bind_param("i", $order_id);
                
                if (!$returns_stmt->execute()) {
                    throw new Exception('Failed to delete return record');
                }
                $returns_stmt->close();
            }
            
            echo json_encode(['status' => 'success', 'message' => 'Order status updated successfully']);
        } else {
            throw new Exception('Failed to update order status');
        }

        $orders_stmt->close();

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>