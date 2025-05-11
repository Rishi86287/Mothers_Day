<?php
session_start();
$ref = $_GET['ref'] ?? '';
if (!$ref) die("No ref provided.");

$lines = file("pending_refs.txt", FILE_IGNORE_NEW_LINES);
$remaining = [];
$approved = [];

foreach ($lines as $line) {
  if (str_starts_with($line, $ref . " |")) {
    $approved[] = $line;
    $_SESSION['verified'] = true;
  } else {
    $remaining[] = $line;
  }
}

file_put_contents("pending_refs.txt", implode("\n", $remaining));

if (!empty($approved)) {
  foreach ($approved as $line) {
    list($ref_id, $name, $email, $phone) = explode(" | ", $line);

    // Send to Google Sheet using Apps Script Web URL
    $google_script_url = "https://script.google.com/macros/s/AKfycbxHhOjZWrkl45e5ob1D76QWFMTejytdtprJOBq9Tgsq_XkcKXDRuIhgsFq2Mx0Uqp6Jvw/exec";
    $url = $google_script_url .
      "?ref=" . urlencode($ref_id) .
      "&name=" . urlencode($name) .
      "&email=" . urlencode($email) .
      "&phone=" . urlencode($phone);

    // Use cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // optional for Android hosting
    curl_exec($ch);
    curl_close($ch);

    // Send email to user
    $subject = "Access Approved: Your Secure PDF is Ready";
    $message = "Hello $name,\n\nYour payment has been approved. Visit the site to view the PDF.\n\nThanks!";
    $headers = "From: danybode7@gmail.com";
    
  /*  require_once 'sendmail.php';
    sendApprovalEmail($email, $name);
    
    $success = mail($email, $subject, $message, $headers);
    if (!$success) {
    file_put_contents("mail_error.log", "Failed to send email to $email\n", FILE_APPEND);
    }
   */ 
  }
}

header("Location: index.php");
?>