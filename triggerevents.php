<?php
session_start();
require_once('classes/dbConnection.php');

$db=new DBConn();

if($_GET['status'] == 0)
{
		mysql_query("UPDATE payments SET collected = 1 WHERE student_matric = '".$_GET['matric']."' AND material_Id = '".$_GET['materialId']."'") or die(mysql_error());
		
		header("location:viewpayment.php");
}
else
{
	mysql_query("UPDATE payments SET collected = 0 WHERE student_matric = '".$_GET['matric']."' AND material_Id = '".$_GET['materialId']."'") or die(mysql_error());
		
		header("location:viewpayment.php");
}

?>