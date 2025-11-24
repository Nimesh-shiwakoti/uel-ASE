<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'toys.bamshawali.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@toys.bamshawali.com'; // your email
    $mail->Password   = 'Nimesh@123';      // your email password
    $mail->SMTPSecure = 'ssl'; // use SSL
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('info@toys.bamshawali.com', 'ToysZone.com');
    $mail->addAddress('nimesh.shiwakoti@gmail.com', 'Test Recipient'); // Change to the recipient email

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from ToysZone.com';
    $mail->Body    = '<h2>Hello!</h2><p>This is a test email sent using PHPMailer via cPanel SMTP.</p>';

    $mail->send();
    echo "Test email sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
