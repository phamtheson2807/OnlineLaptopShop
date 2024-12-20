<?php
session_start();
include '../config/database.php';

// Verify OTP
if(isset($_POST['verify_otp'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp = ?");
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    
    if($stmt->get_result()->num_rows > 0) {
        header("Location: ../views/resetPASSWORD.php?email=" . urlencode($email));
    } else {
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Invalid OTP";
        header("Location: ../views/forgotPASSWORD.php");
    }
}

// Update Password
if(isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("UPDATE users SET password = ?, otp = NULL WHERE email = ?");
    $stmt->bind_param("ss", $password, $email);
    
    if($stmt->execute()) {
        $_SESSION['message'] = "Password updated successfully!";
        header("Location: ../views/resetPASSWORD.php");
        exit();
    } else {
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Failed to update password";
        header("Location: ../views/resetPASSWORD.php?email=" . urlencode($email));
    }
}
?>