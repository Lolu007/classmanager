<?php 
		session_start();
error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(E_ALL ^ E_NOTICE);
		//including the file that contains the AdminManager class
		require_once("classes/adminCodes.php");
		require_once("classes/ps_pagination.php");
		
		$admin = new AdminManager();
		
		$db2 = new DBConn2();
		$db = new DBConn();
		
		$adminstatus = base64_decode($_GET['adminstatus']);
		$user = base64_decode($_GET['user']);
		$name = base64_decode($_GET['name']);
		
		if(!isset($_SESSION['adminId'])&&($_SESSION['logged']!=true))
		{
			header("location:index.php?error=".base64_encode("Unathourized Access, please login"));
		}
		
		$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM materials_sale order by datecreated desc",10,3);
		$rs = $pager->paginate();
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::VIEW MATERIALS</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>

<script language="javascript">
	function validate()
	{
	
		var id = document.getElementById('hide').value;
		if(confirm("Are you sure you want to perform this operation"))
			return true;
		else
			return false;	
	}	
</script>
<style type="text/css">
<!--
.style8 {font-size: 10}
.style9 {color: #CCCC00}
.style10 {font-family: "trebuchet MS"}
.style13 {font-size: 14px}
.style14 {font-size: 16px}
.style15 {color: #FFFFFF}
-->
</style>
</head>

<body><center>
<div id="container">
		<?php include("header.php"); ?>
		<div id="contentWrapper">
				<div id="content">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20%" valign="top" bgcolor="#CCCC00">
								<div id="sidenav">
						   			 <?php include("sidenav.php"); ?>
						  		</div>							</td>
						  <td width="75%" valign="top">
						  <table width="100%" cellpadding="2" cellspacing="1">
                            <tr>
                              <td colspan="10">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="10" align="center">TIME-TABLE</td>
                            </tr>
                            
                            <tr>
                              <td align="left" valign="top" colspan="10">
                              	<table width="100%">
                                <tr>
                                   	<td width="20%">&nbsp;</td>     
                                    <td width="80%" valign="middle" bgcolor="#D7D760">&nbsp;</td>
                               	</tr>
                               </table>
                              </td>
                            </tr>
                          </table></td>
							<td width="5%" align="left" valign="top" bgcolor="#CCCC00">
						 <br /><br />
						   </td>
						</tr>
					</table>
					<div id="footer"><?php include("footer.php"); ?></div>
				</div>
		</div>
</div>
</center></body>
</html>