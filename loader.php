<?php
session_start();
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
  http_response_code(403);
  die("Access denied");
}

$path = __DIR__ . '/secret/secure.pdf';
if (!file_exists($path)) {
  http_response_code(404);
  die("File not found");
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="document.pdf"');
readfile($path);
?>
