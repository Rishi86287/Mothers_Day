<?php
session_start();
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$ref_id = trim($_POST['ref_id'] ?? '');

if (!$name || !$email || !$phone || !$ref_id) {
  die("All fields are required.");
}

$entry = implode(" | ", [$ref_id, $name, $email, $phone]);
file_put_contents("pending_refs.txt", $entry . "\n", FILE_APPEND);

// Email to admin
$to = "rr8382658@gmail.com";
$subject = "New UPI Payment Submission";
$message = "Name: $name\nEmail: $email\nPhone: $phone\nRef ID: $ref_id";
$headers = "From: notifier@yourdomain.com";
mail($to, $subject, $message, $headers);

echo "<h2>Reference ID Submitted</h2><p>Wait for admin approval.</p><a href='index.php'>Back</a>";
?>
?>
