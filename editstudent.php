<?php 
		session_start();
//error_reporting(E_ALL ^ E_NOTICE);
//		error_reporting(E_ALL ^ E_NOTICE);
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
		
		
		$sqlh="SELECT * FROM hallofres Order by hall";
		$resh=mysql_query($sqlh) or die(mysql_error());
		$rsh=mysql_fetch_assoc($resh);
		$numrsh=mysql_num_rows($resh);
		
		$qry = "SELECT * FROM classmembers WHERE matricNo ='".$_GET['matric']."'";
		$std = $db->fetchData($qry);
		
		$dob = explode(" ",$std['dob']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::EDIT STUDENT'S DETAILS::</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<style type="text/css">
<!--
.style8 {color: #FF0000}
-->
</style>
<script language="javascript" src="javascript/functions.js"></script>
<script language="javascript" src="javascript/util.js"></script>


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
									  <td align="center"><table width="70%">
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
                                                  <td colspan="2" align="left"><div id="hdline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EDIT DETAILS</div></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="2" align="left"><div id="info"></div></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="2">
                                                      <fieldset class="basicInfo">
                                                        <legend>Basic Information</legend>
                                                        <table width="100%">
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Matric Number </td>
                                                          <td width="62%">
                                                            <input name="matric" type="text" id="matric" value="<?php echo $std['matricNo']; ?>" />
                                                         </td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">First Name </td>
                                                          <td width="62%"><input name="fname" type="text" id="fname" value="<?php echo $std['fname']; ?>"/></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Middle Name </td>
                                                          <td width="62%"><input name="mname" type="text" id="mname" value="<?php echo $std['mname']; ?>"/></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Last Name </td>
                                                          <td width="62%"><input name="lname" type="text" id="lname" value="<?php echo $std['lname']; ?>"/></td>
                                                        </tr>
                                                      </table>
                                                      </fieldset></td>
                                                </tr>
												
												<tr>
													<td colspan="2">
														<table width="100%" class="basicInfo">
															<tr>
															  <td width="38%" valign="middle">Date Of Birth </td><td width="40%" align="center" valign="middle"><select name="mon" id="mon" onchange="loadDays();"><option value="" <?php if($dob[0]=="") echo "selected='selected'"; ?>>-select-</option>
                                                                <option value="January" <?php if($dob[0]=="January") echo "selected='selected'"; ?>>January</option>
                                                                <option value="February" <?php if($dob[0]=="February") echo "selected='selected'"; ?>>February</option>
                                                                <option value="March" <?php if($dob[0]=="March") echo "selected='selected'"; ?>>March</option>
                                                                <option value="April" <?php if($dob[0]=="April") echo "selected='selected'"; ?>>April</option>
                                                                <option value="May" <?php if($dob[0]=="May") echo "selected='selected'"; ?>>May</option>
                                                                <option value="June" <?php if($dob[0]=="June") echo "selected='selected'"; ?>>June</option>
                                                                <option value="July" <?php if($dob[0]=="July") echo "selected='selected'"; ?>>July</option>
                                                                <option value="August" <?php if($dob[0]=="August") echo "selected='selected'"; ?>>August</option>
                                                                <option value="September" <?php if($dob[0]=="September") echo "selected='selected'"; ?>>September</option>
                                                                <option value="October" <?php if($dob[0]=="October") echo "selected='selected'"; ?>>October</option>
                                                                <option value="November" <?php if($dob[0]=="November") echo "selected='selected'"; ?>>November</option>
                                                                <option value="December" <?php if($dob[0]=="December") echo "selected='selected'"; ?>>December</option>
                                                              </select>
															    month</td><td width="22%" align="left"><select name="days" id="days"><option value="<?php echo $dob[1]; ?>"><?php echo $dob[1]; ?></option></select>
															      day</td>
														  </tr>
													  </table>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<table width="100%" class="basicInfo">
															<tr>
															  <td width="38%" valign="middle">Sex:</td>
                                                              <td width="62%" valign="middle">
                                                              	<select name="gender" id="gender">
                                                       	      <option value="Male" <?php if($std['sex']=="Male") echo "selected='selected'"; ?> >Male</option>
                                                                    <option value="Female" <?php if($std['sex']=="Female") echo "selected='selected'"; ?>>Female</option>
                                                                </select>
                                                              </td>
															</tr>
													  </table>
													<br /></td>
												</tr>
												<tr>
												  <td colspan="2">
                                                      <fieldset>
                                                        <legend>Contact Information</legend>
                                                        <table width="100%">
														
														<tr>
                                                          <td width="38%" align="left" class="tblabel">Hall</td>
                                                          <td width="62%">
														  	<select name="hall"><option value="" <?php if($std['hallofres']=="") echo "selected='selected'";?>>-select-</option>
																<?php do { ?>
																	  <option value="<?php echo $rsh['hallcode']; ?>" <?php if($std['hallofres']==$rsh['hallcode']) echo "selected='selected'";?>><?php echo $rsh['hall']; ?></option>
																	  <?php } while ($rsh=mysql_fetch_assoc($resh)); ?>
															</select>
														  </td>
                                                        </tr>
														<tr>
														  <td width="38%">Room Number </td>
														  <td width="62%"><input name="roomno" type="text" id="roomno" size="10" maxlength="10" value="<?php echo $std['roomno']; ?>"/></td>
														  </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Phone </td>
                                                          <td width="62%" valign="middle">
                                                            <input name="phone" type="text" id="phone" value="<?php echo $std['phone']; ?>"/>                                                     </td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Email</td>
                                                          <td width="62%"><input name="email" type="text" id="email" value="<?php echo $std['email']; ?>"/></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Address </td>
                                                          <td width="62%"><textarea name="address" id="address"><?php echo $std['address']; ?></textarea></td>
                                                        </tr>
                                                        <tr>
                                                          <td width="38%" align="left" class="tblabel">Next Of Kin Name </td>
                                                          <td width="62%"><input name="kinname" type="text" id="kinname" value="<?php echo $std['nextofkin_name']; ?>"/></td>
                                                        </tr>
														<tr>
                                                          <td width="38%" align="left" class="tblabel">Next Of Kin Phone </td>
                                                          <td width="62%"><input name="kinphone" type="text" id="kinphone" value="<?php echo $std['nextofkin_phone']; ?>"/></td>
                                                        </tr>
														
                                                      </table>
                                                      </fieldset></td>
                                                </tr>
                                                <tr>
                                                  <td width="38%">
                                                  		<a href="viewclass.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>" title="View Class">
                                                  		<div class="submenu">&lt;&lt;View Class</div>
                                                  		</a>
                                                  </td>
                                                  <td width="62%"><input type="button" title="Save changes" name="submit" id="submit" value="Save Changes" onclick="editstud('regform','ajax/ajax_request.php','info');"/>
												  </td>
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
								  
						  <?php }?><br /><br /><br />
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
