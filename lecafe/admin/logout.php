<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/lecafe/core/init.php';
unset($_SESSION['SBUser']);
header('Location: /lecafe/admin/users.php');
?>