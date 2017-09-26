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
		
		if(isset($adminstatus) && $adminstatus != 1)
		{
			header("location:home.php?adminstatus=".base64_encode($adminstatus)."&user=".base64_encode($user)."&name=".base64_encode($name));
		}
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::ADD RESULT::</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<style type="text/css">
<!--
.style8 {color: #FF0000}
-->
</style>
<script language="javascript" src="javascript/functions.js"></script>
<script language="javascript" src="javascript/util.js"></script>

<script language="javascript">
<!--
	$(document).ready(function(){
		$('#cont').click(function(e){
			$('#contactInfo').slideDown(400);
			$('#cont').slideUp(400);
		});
		
	});
//-->
</script>
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
									  <td align="center"><table width="60%">
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td><form id="regform" name="regform" method="post" action="">
                                              <table width="100%" border="0" cellpadding="4" cellspacing="4">
                                                <tr>
                                                  <td colspan="2" align="left"><div id="hdline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student's Result </div></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="2" align="left"><div id="info"></div></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="2">
                                                      <fieldset class="basicInfo">
                                                        <legend>Enter CGPA Here</legend>
                                                        <table width="100%">
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Matric Number </td>
                                                          <td width="62%">
                                                            <input name="matric" type="text" id="matric" />                                                         </td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">CGPA</td>
                                                          <td width="62%"><input name="cgpa" type="text" id="cgpa" /></td>
                                                        </tr>
                                                      </table>
                                                      </fieldset></td>
                                                </tr>
												<tr>
												  <td colspan="2">
                                                      <fieldset id="contactInfo">
                                                        <legend>Contact Information</legend>
                                                        <table width="100%">
														
														<tr>
                                                          <td width="38%" align="left" class="tblabel">Hall</td>
                                                          <td width="62%">
														  	<select name="hall">
																<option value="">--Select--</option>
																<?php do { ?>
																	  <option value="<?php echo $rsh['hallcode']; ?>"><?php echo $rsh['hall']; ?></option>
																	  <?php } while ($rsh=mysql_fetch_assoc($resh)); ?>
															</select>														  </td>
                                                        </tr>
														<tr>
														  <td width="38%">Room Number </td>
														  <td width="62%"><input name="roomno" type="text" id="roomno" size="10" maxlength="10" /></td>
														  </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Phone </td>
                                                          <td width="62%" valign="middle">
                                                            <input name="phone" type="text" id="phone" />                                                     </td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Email</td>
                                                          <td width="62%"><input name="email" type="text" id="email" /></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Address </td>
                                                          <td width="62%"><textarea name="address" id="address"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Next Of Kin Name </td>
                                                          <td width="62%"><input name="kinname" type="text" id="kinname" /></td>
                                                        </tr>
														<tr>
                                                          <td width="38%" align="left" class="tblabel">Next Of Kin Phone </td>
                                                          <td width="62%"><input name="kinphone" type="text" id="kinphone" /></td>
                                                        </tr>
                                                      </table>
                                                      </fieldset></td>
                                                </tr>
                                                <tr>
                                                  <td width="38%">&nbsp;</td>
                                                  <td width="62%"><input type="button" title="Submit details"name="submit" id="submit" value="Submit" onclick="results('regform','ajax/ajax_request.php','info');"/>												  </td>
                                                </tr>
                                                <tr>
                                                  <td colspan="2"><hr />
                                                    &nbsp;</td>
                                                </tr>
                                              </table>
                                          </form></td>
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
