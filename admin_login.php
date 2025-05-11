<?php
session_start();
$pass = 'admin123'; // Change this password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['password'] === $pass) {
    $_SESSION['admin'] = true;
    header('Location: admin.php');
    exit;
  } else {
    $error = "Incorrect password.";
  }
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
  <h2>Admin Login</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post">
    <input type="password" name="password" placeholder="Admin Password" required>
    <button type="submit">Login</button>
  </form>
</body>
</html>
