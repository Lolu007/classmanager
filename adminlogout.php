<?php
session_start();
require_once("classes/adminCodes.php");

$admin = new AdminManager();
$admin->adminLogout();
//$db->close();
?>