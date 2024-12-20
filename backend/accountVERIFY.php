<?php 

session_start(); // Start the session to use session variables
include '../config/database.php';

if (isset($_POST['verify'])) {
    $otp = $_POST['otp'];
    $email = $_POST['email']; 


    // Prepare a statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE otp = ? AND email = ?");
    $stmt->bind_param("is", $otp, $email); // "i" for integer (OTP), "s" for string (email)
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the OTP exists for the provided email
    if ($result->num_rows > 0) {
        // Update the user's status and reset the OTP
        $updateStmt = $conn->prepare("UPDATE `users` SET status = 'verified' WHERE otp = ? AND email = ?");
        $updateStmt->bind_param("is", $otp, $email);
        $updateResult = $updateStmt->execute();

        if ($updateResult) {
            // Fetch user details to set session variables
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            echo "<script>alert('registration complete'); window.location.href='../views/loginPAGE.php';</script>";
            exit; // Exit after redirect
        } else {
            echo "Failed to update user status.";
        }
    } else {
        echo "Invalid OTP or email. Please try again.";
    }
    
    // Close statements
    $stmt->close(); ;
    $conn->close();
}
?>
