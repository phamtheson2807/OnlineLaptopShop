<?php
include '../../config/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $return_id = $_POST['return_id'];
    $status = $_POST['status'];
    
    try {
        $conn->begin_transaction();

        // Update returns table
        $sql = "UPDATE returns SET status = ? WHERE return_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $return_id);
        $stmt->execute();

        // Get order_id from returns table
        $sql = "SELECT order_id FROM returns WHERE return_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $return_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        
        // Update orders table with corresponding status
        $order_status = '';
        switch($status) {
            case 'Approved':
                $order_status = 'For Returned';
                break;
            case 'Rejected':
                $order_status = 'Complete';
                break;
            case 'Pending':
                $order_status = 'Pending';
                break;
        }
        
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $order_status, $order['order_id']);
        $stmt->execute();

        $conn->commit();
        echo json_encode(['status' => 'success']);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

$conn->close();
?>