<?php
include '../../config/database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$admin_id = 2; // Static admin ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $conn->begin_transaction();

        if (!isset($_POST['order_id']) || !isset($_POST['return_reason']) || !isset($_FILES['return_file'])) {
            throw new Exception('Missing required fields');
        }

        $order_id = $_POST['order_id'];

        // Check if return already exists
        $sql = "SELECT return_id FROM returns WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            throw new Exception('This Item has an history of return!');
        }

        // File upload handling
        $target_dir = "../../uploads/returns/";
        $file_extension = pathinfo($_FILES["return_file"]["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["return_file"]["tmp_name"], $target_file)) {
            // Insert return record
            $sql = "INSERT INTO returns (order_id, user_id, reason, image_path, status) 
                    VALUES (?, ?, ?, ?, 'Pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiss", $order_id, $user_id, $_POST['return_reason'], $file_name);
            $stmt->execute();

            // Update order status
            $sql = "UPDATE orders SET status = 'Return Pending' WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $order_id);
            $stmt->execute();

            $conn->commit();
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception('Failed to upload file');
        }
    } catch (Exception $e) {
        $conn->rollback();
        error_log($e->getMessage());
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

$sql = "SELECT ao.order_id, p.name as product_name 
        FROM allorder ao
        JOIN orders o ON ao.order_id = o.order_id
        JOIN products p ON ao.product_id = p.product_id
        WHERE ao.user_id = ? AND o.status = 'Complete'
        ORDER BY ao.all_order_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode(['orders' => $orders]);

$stmt->close();
$conn->close();
?>