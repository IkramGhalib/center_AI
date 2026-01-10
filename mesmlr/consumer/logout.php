<?php
session_start();
unset($_SESSION['cust_id']);
unset($_SESSION['name']);
unset($_SESSION['cid']);
session_destroy();

header("Location: login.php");
exit;
?>