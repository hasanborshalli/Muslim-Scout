<?php
session_start();
$session=array();
session_destroy();
header("Location:login.php");
exit;
?>