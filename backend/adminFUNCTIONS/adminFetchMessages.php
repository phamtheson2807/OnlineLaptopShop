<?php
include '../../config/database.php';
session_start();

header('Content-Type: application/json'); // Set JSON header

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$admin_id = $_SESSION['user_id'];

// Get users with unread message count
if (isset($_GET['users'])) {
    $sql = "SELECT 
            u.user_id, 
            u.first_name,
            u.last_name,
            (SELECT COUNT(*) FROM messages 
             WHERE sender_id = u.user_id 
             AND receiver_id = 2 
             AND is_read = 0) as unread_count,
            MAX(m.timestamp) as last_message
            FROM users u
            LEFT JOIN messages m ON u.user_id = m.sender_id 
            WHERE u.is_admin = 0
            GROUP BY u.user_id
            ORDER BY unread_count DESC, last_message DESC";

    $result = $conn->query($sql);
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
    exit;
}

if (isset($_GET['get_users'])) {
    $sql = "SELECT 
            u.user_id, 
            u.first_name, 
            u.last_name,
            (SELECT COUNT(*) FROM messages 
             WHERE sender_id = u.user_id 
             AND receiver_id = ? 
             AND is_read = 0) as unread_count
            FROM users u
            WHERE u.is_admin = 0
            ORDER BY unread_count DESC, u.user_id ASC";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];
    
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'user_id' => $row['user_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'unread_count' => (int)$row['unread_count']
        ];
    }
    echo json_encode(['users' => $users]);
    exit;
}

// Mark messages as read when admin opens chat
if (isset($_GET['mark_read'])) {
    $sender_id = $_GET['sender_id'];
    $sql = "UPDATE messages SET is_read = 1 
            WHERE sender_id = ? AND receiver_id = ? AND is_read = 0";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $sender_id, $admin_id);
    mysqli_stmt_execute($stmt);
}

// Update messages to read when admin opens chat
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $sender_id = $data['sender_id'];
    
    $sql = "UPDATE messages SET is_read = 1 
            WHERE sender_id = ? AND receiver_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $sender_id, $admin_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}

// Fetch messages with user info
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['get_unread'])) {
        try {
            ob_clean();
            
            // Test direct query first
            $direct_query = mysqli_query($conn, "SELECT COUNT(*) as unread FROM messages WHERE receiver_id = 2 AND sender_id != 2 AND is_read = 0");
            $direct_result = mysqli_fetch_assoc($direct_query);
            
            // Log raw results
            error_log("Direct query result: " . print_r($direct_result, true));
            
            // Return raw count from direct query
            echo json_encode([
                'admin Sidebar unread_count' => (int)$direct_result['unread'],
                'debug' => [
                    'raw_count' => $direct_result['unread'],
                    'query' => "SELECT COUNT(*) as unread FROM messages WHERE receiver_id = 2 AND sender_id != 2 AND is_read = 0"
                ]
            ]);
            
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

    if (isset($_GET['check_unread'])) {
        $sql = "SELECT COUNT(*) as unread 
                FROM messages 
                WHERE receiver_id = ? 
                AND is_read = 0";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $admin_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $unread = mysqli_fetch_assoc($result);
        
        ob_clean();
        echo json_encode(['unread_count' => (int)$unread['unread']]);
        exit;
    }

    $receiver_id = mysqli_real_escape_string($conn, $_GET['receiver_id']);
    $sql = "SELECT m.*, 
            CONCAT(u1.first_name, ' ', u1.last_name) as sender_name,
            CONCAT(u2.first_name, ' ', u2.last_name) as receiver_name
            FROM messages m
            JOIN users u1 ON m.sender_id = u1.user_id
            JOIN users u2 ON m.receiver_id = u2.user_id
            WHERE (m.sender_id = ? AND m.receiver_id = ?) 
            OR (m.sender_id = ? AND m.receiver_id = ?) 
            ORDER BY m.timestamp";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $admin_id, $receiver_id, $receiver_id, $admin_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        echo json_encode(['error' => mysqli_error($conn)]);
        exit;
    }
    
    $result = mysqli_stmt_get_result($stmt);
    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($messages);
}

// Send message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = mysqli_real_escape_string($conn, $_POST['receiver_id']);
    $message_text = mysqli_real_escape_string($conn, $_POST['message_text']);
    $attachment_link = null;

    // Add file upload handling
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
    mysqli_stmt_bind_param($stmt, "iiss", $admin_id, $receiver_id, $message_text, $attachment_link);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
}

mysqli_close($conn);
?>