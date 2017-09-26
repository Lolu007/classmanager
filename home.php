<?php 
		
		session_start();
error_reporting(E_ALL ^ E_NOTICE);
		 error_reporting(E_ALL ^ E_NOTICE);
		//including the file that contains the AdminManager class
		require_once("classes/adminCodes.php");
		require_once("classes/ps_pagination.php");
		
		$admin = new AdminManager();
		$db = new DBConn();
		
		
		$adminstatus = base64_decode($_GET['adminstatus']);
		$user = base64_decode($_GET['user']);
		$name = base64_decode($_GET['name']);
		
		if(!isset($_SESSION['adminId'])&&($_SESSION['logged']!=true))
		{
			header("location:index.php?error=".base64_encode("Unathourized Access, please login"));
		}
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::HOMEPAGE</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<style type="text/css">
<!--
.style10 {font-size: 11px}

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
							<td width="60%" valign="top">
								<table width="100%">
									<tr>
										<td align="left" valign="top"><center></center></td>
									</tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
								  </tr>
								</table>
							</td>
							<td width="20%" align="left" valign="top" bgcolor="#CCCC00"  >
								<?php if(isset($adminstatus) && $adminstatus==1){ include("adminrightnav.php"); ?>
								  	
						 		 <?php }?><br /><br/><br /><br />
						  <div id="right_below"><?php include("calender/calender.php"); ?></div>
						  </td>
						</tr>
					</table>
					<div id="footer"><?php include("footer.php"); ?></div>
				</div>
		</div>
</div>
</center></body>
</html>
