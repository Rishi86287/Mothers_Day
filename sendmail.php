<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

function sendApprovalEmail($to, $name) {
  $mail = new PHPMailer(true);

  try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Or your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'danybode7@gmail.com'; // Your Gmail address
    $mail->Password   = 'ebjl lkmu psbt ryzk';    // Use App Password (not your real password)
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email settings
    $mail->setFrom('danybode7@gmail.com', 'Your Name or Business');
    $mail->addAddress($to, $name);
    $mail->Subject = 'Access Approved: Secure PDF';
    $mail->Body    = "Hello $name,\n\nYour payment has been approved. You may now view the secured PDF document on our website.\n\nThanks!";
    $mail->send();

    return true;
  } catch (Exception $e) {
    error_log("Mailer Error: " . $mail->ErrorInfo);
    return false;
  }
}
?>