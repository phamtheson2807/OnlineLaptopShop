<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendOTP($email, $otp) {
    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;
        $mail->Username = 'Harveycasane@gmail.com'; // SMTP username
        $mail->Password = 'wrmq lhrf uxnu fgmv'; // SMTP password or App Password if 2FA is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('Harveycasane@gmail.com', 'Online Laptop Shop');
        $mail->addAddress($email); // Add a recipient

        // Add embedded image
        $image_path = '../assets/images/therock.png';
        $mail->addEmbeddedImage($image_path, 'logo', 'therock.png');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = '
            <div style="text-align: center;">
                <img src="cid:logo" style="width: 200px; height: auto;"><br><br>
                <h1>Welcome to Online Laptop Shop</h1>
                <h2>Your OTP Verification Code</h2>
                <h1 style="color: #4a90e2;"><b>' . $otp . '</b></h1>
            </div>';

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
