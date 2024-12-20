<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient_email = $_POST['recipient_email'];
    $order_id = $_POST['order_id'];
    $message_content = $_POST['message_content'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $carrier = $_POST['carrier'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'Harveycasane2@gmail.com'; // Your Gmail
        $mail->Password = 'ueao ifiu uypm uuhn'; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('Harveycasane2@gmail.com', 'GenZ Laptop Shop');
        $mail->addAddress($recipient_email); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Order #$order_id - Message from GenZ Laptop Shop";
        $mail->Body = "
            <div style='text-align: center;'>
                <hr>
                    <p>Dear Customer,</p>

                    <p>Thank you for your recent purchase from Online Laptop Shop. Below are the details of your order:</p>

                    <p><strong>Product:</strong> $product</p>

                    <p><strong>Quantity:</strong> $quantity</p>

                    <p><strong>Unit Price:</strong> $unit_price</p>

                    <p><strong>Total Price:</strong> $total_price</p>

                    <p><strong>Payment Method:</strong> $payment_method</p>

                    <p><strong>Carrier:</strong> $carrier</p>
                <hr>
            <div style='text-align: start; margin: 20px; padding: 20px; border: 1px solid #ddd;'>
                <p>Sincerely,</p>
                <p>Online Laptop Shop Team</p>
                <p>$message_content</p>
                </div>
                <p></p>
                <p>Thank you for shopping with Online Laptop Shop!</p>
            </div>";
        $mail->send();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";   
    }
}
?>