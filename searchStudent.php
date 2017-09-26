<?php
session_start();
require_once("classes/adminCodes.php");
$student = new ClassManager();
echo $student->searchStudent();
?>