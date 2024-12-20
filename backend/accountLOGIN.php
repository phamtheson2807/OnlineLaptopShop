<?php

include '../config/database.php';
session_start(); 

if (isset($_POST['login'])) {
    $emailOrUsername = $_POST['emailOrUsername'];
    $password = $_POST['password'];
  
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
 
        if (password_verify($password, $row['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['is_admin'] = (bool)$row['is_admin']; // Cast to boolean
            
            // Debug logging
            error_log("User ID: " . $row['user_id'] . " Is Admin: " . $row['is_admin']);
            
            // Redirect based on user type - check both 1 and true conditions
            if ($row['is_admin'] == 1 || $row['is_admin'] === true) {
                header('location: ../views/admin/adminVIEW.php');
            } else {
                header('location: ../views/user/userVIEW.php');
            }
            exit();
        } else {
            $_SESSION['error'] = "Login Failed. Incorrect password.";
            header('location: ../views/loginPAGE.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "No User Found!";
        header('location: ../views/loginPAGE.php');
        exit();
    }
    $stmt->close();
}

?>
