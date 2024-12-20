<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
include '../config/database.php';
require_once '../includes/sendOTP.php';

// Debug request
error_log('Received POST data: ' . print_r($_POST, true));

// Check exact values
error_log('reset value: ' . (isset($_POST['reset']) ? $_POST['reset'] : 'not set'));
error_log('email value: ' . (isset($_POST['email']) ? $_POST['email'] : 'not set'));

header('Content-Type: application/json');

// Modified check to see what's missing
if(!isset($_POST['reset'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing reset parameter'
    ]);
    exit;
}

if(!isset($_POST['email'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing email parameter'
    ]);
    exit;
}

// Ensure no output before this point
ob_start(); // Start output buffering

if(isset($_POST['reset'])) {
    // Clear any previous output
    ob_clean();
    
    // Set headers
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, must-revalidate');
    
    $email = $_POST['email'];
    
    try {
        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            // Generate OTP
            $otp = rand(100000, 999999);
            
            // Update user's OTP in database
            $updateStmt = $conn->prepare("UPDATE users SET otp = ? WHERE email = ?");
            $updateStmt->bind_param("is", $otp, $email);
            
            if($updateStmt->execute()) {
                try {
                    sendOTP($email, $otp);
                    $response = ['success' => true, 'email' => $email];
                } catch (Exception $e) {
                    $response = ['success' => false, 'message' => 'Failed to send OTP email'];
                }
            } else {
                $response = ['success' => false, 'message' => 'Failed to update OTP'];
            }
            $updateStmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Email not found'];
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        $response = ['success' => false, 'message' => 'Server error occurred'];
    }
    
    $conn->close();
    
    // Ensure only JSON is output
    ob_end_clean(); // Clean all output buffers
    echo json_encode($response);
    exit;
}
?>