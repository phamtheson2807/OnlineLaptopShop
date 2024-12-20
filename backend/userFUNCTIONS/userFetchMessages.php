<?php
ob_start();
error_reporting(0); // Suppress PHP errors
include '../../config/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    ob_clean();
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $receiver_id = mysqli_real_escape_string($conn, $_GET['receiver_id']);
    
    // First update messages to read
    $update_sql = "UPDATE messages 
                   SET is_read = 1 
                   WHERE receiver_id = ? 
                   AND sender_id = ? 
                   AND is_read = 0";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $receiver_id);
    mysqli_stmt_execute($stmt);

    // Then fetch messages
    $sql = "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) as sender_name 
            FROM messages m 
            JOIN users u ON m.sender_id = u.user_id 
            WHERE (m.sender_id = ? AND m.receiver_id = ?) 
            OR (m.sender_id = ? AND m.receiver_id = ?) 
            ORDER BY m.timestamp";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $user_id, $receiver_id, $receiver_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    echo json_encode($messages);
}

if (isset($_GET['check_unread'])) {
    try {
        if (!$conn) {
            throw new Exception('Database connection failed');
        }

        $sql = "SELECT COUNT(*) as unread 
                FROM messages 
                WHERE receiver_id = ? 
                AND sender_id = 2 
                AND is_read = 0";
        
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception('Query preparation failed');
        }

        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Query execution failed');
        }

        $result = mysqli_stmt_get_result($stmt);
        $unread = mysqli_fetch_assoc($result);
        
        ob_clean();
        echo json_encode(['unread_count' => (int)$unread['unread']]);
    } catch (Exception $e) {
        ob_clean();
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = mysqli_real_escape_string($conn, $_POST['receiver_id']);
    $message_text = mysqli_real_escape_string($conn, $_POST['message_text']);
    $attachment_link = null;

    if (isset($_FILES['attachment'])) {
        $file = $_FILES['attachment'];
        $fileName = time() . '_' . $file['name'];
        $uploadPath = '../../uploads/messagingAttachments/';
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath . $fileName)) {
            $attachment_link = 'uploads/messagingAttachments/' . $fileName;
        }
    }
    
    $sql = "INSERT INTO messages (sender_id, receiver_id, message_text, attachment_link) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiss", $user_id, $receiver_id, $message_text, $attachment_link);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read'])) {
    $sender_id = $_POST['sender_id'];
    
    $sql = "UPDATE messages 
            SET is_read = 1 
            WHERE receiver_id = ? 
            AND sender_id = ? 
            AND is_read = 0";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $sender_id);
    mysqli_stmt_execute($stmt);
    
    echo json_encode(['status' => 'success']);
    exit;
}

mysqli_close($conn);
?>