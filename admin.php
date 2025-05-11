<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
  header('Location: admin_login.php');
  exit;
}
$pending_refs = file_exists("pending_refs.txt") ? file("pending_refs.txt", FILE_IGNORE_NEW_LINES) : [];
?>
<h2>Admin Approval Panel</h2>
<ul>
<?php foreach ($pending_refs as $line): ?>
  <?php list($ref, $name, $email, $phone) = explode(" | ", $line); ?>
  <li>
    <strong><?php echo htmlspecialchars($name); ?></strong> - <?php echo htmlspecialchars($email); ?> - <?php echo htmlspecialchars($phone); ?> - Ref: <?php echo htmlspecialchars($ref); ?>
    <a href="approve.php?ref=<?php echo urlencode($ref); ?>">[Approve]</a>
  </li>
<?php endforeach; ?>
</ul>>