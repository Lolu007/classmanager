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
			header("location:index.php?error=".base64_encode("You are not logged in"));
		}
		
		if(isset($_POST['save']))
		{
			$info = $admin->editAdmin();
		}	
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::EDITING PROFILE</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<style type="text/css">
<!--
.style8 {color: #FF0000}
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
						  		</div>
						  </td>
							<td width="60%" valign="top">
								<table width="100%">
									<tr>
										<td align="center">
											<table width="60%">
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>
													<form id="form1" name="form1" method="post" action="">
														  <table width="100%" border="0" cellpadding="4" cellspacing="4">
															<tr>
															  <td colspan="2" align="left">
															  <div id="hdline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Managing your Profile
															    </div>															  </td>
															</tr>
															<?php if(isset($info)){?>
															<tr>
															  <td colspan="2" align="left"><div id="info"><?php echo $info; ?></div></td>
															</tr>
															<?php }?>
															<tr>
															<td colspan="2">
																<fieldset><legend>Login Details</legend>
																	<table width="100%">
																	<tr>
																	  <td width="33%" align="left" class="tblabel">Username:</td>
																	  <td width="67%"><input name="adminuser" type="text" id="adminuser" value="<?php echo $row['username']; ?>" maxlength="8"/><br />
																      <span class="style6 style8"><em>min 6 characters & max 8 characters</em></span></td>
																	</tr>
																	<tr>
																	  <td width="33%" align="left" class="tblabel">Password:</td>
																	  <td width="67%"><input type="password" name="password" id="password" value="<?php echo $row['password']; ?>" /></td>
																	</tr>
																	<tr>
																	  <td width="33%" align="left" class="tblabel">Confirm Password:</td>
																	  <td width="67%"><input name="password2" type="password" id="password2" value="<?php echo $row['password']; ?>" /></td>
																	</tr>
																	</table>
																</fieldset>
																<br />
																<fieldset><legend>Admin Info</legend>
																	<table width="100%">
																		<tr>
																		  <td width="33%" align="left" class="tblabel">Name:</td>																		  																	  
																		  <td width="67%"><em>
																		    <input name="name" type="text" id="name" value="<?php echo $row['name']; ?>" />
																	      <span class="style5">Surname first</span></em></td>							 </tr>
																		  
																		  <tr>
																		  <td width="33%" align="left" class="tblabel">Email:</td>																		  																	  
																		  <td width="67%"><input name="email" type="text" id="email" value="<?php echo $row['email']; ?>" /></td>							
																		  </tr>
																		  <tr>
																		  <td width="33%" align="left" class="tblabel">Phone:</td>																		  																	  
																		  <td width="67%"><input name="phone" type="text" id="phone" value="<?php echo $row['phone']; ?>" /></td>							
																		  </tr>
																	</table>
																</fieldset>															</td>
															</tr>
															<tr>
															  <td width="34%">&nbsp;</td>
															  <td width="66%"><input type="submit" title="Submit details"name="save" id="save" value="Apply Changes"/></td>
															</tr>
															<tr>
															  <td colspan="2"><hr />
															  &nbsp;</td>
															</tr>
													  </table>
												  </form>												</td>
											</tr>
											
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
									  </table></td>
									</tr>
								</table></td>
						  <td width="20%" align="left" valign="top" bgcolor="#CCCC00"  >
								<?php if(isset($adminstatus) && $adminstatus==1){ include("adminrightnav.php");?>
								  
						  <?php }?><br /><br /><br /><br />
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
