<?php
session_start();
echo isset($_SESSION['verified']) && $_SESSION['verified'] === true ? "approved" : "pending";
?>
