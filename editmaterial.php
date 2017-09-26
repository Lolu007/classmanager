<?php 
		session_start();
error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(E_ALL ^ E_NOTICE);
		//including the file that contains the AdminManager class
		require_once("classes/adminCodes.php");
		require_once("classes/ps_pagination.php");
		
		$admin = new AdminManager();
		$class = new ClassManager();
		
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
		if(isset($_POST['save']))
		{
			$info = $class->editMaterial();
		}	
		
		//for current logged in admin
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);
		
		//getting material details
		$materialid  = $_GET['materialId'];
		$query="SELECT * FROM materials_sale WHERE material_id='$materialid'";
		$material = $db->fetchData($query);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::MANAGING MATERIAL</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<script language="javascript" src="javascript/functions.js"></script>

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
									  <td align="center"><table width="100%">
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td><form id="form1" name="form1" method="post" action="">
                                              <table width="100%" border="0" cellpadding="4" cellspacing="4">
                                                <tr>
                                                  <td colspan="2" align="left"><div id="hdline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Managing Materials </div></td>
                                                </tr>
                                                <?php if(isset($info)){?>
                                                <tr>
                                                  <td colspan="2" align="left"><div id="info"><?php echo $info; ?></div></td>
                                                </tr>
                                                <?php }?>
                                                <tr>
                                                  <td colspan="2"><fieldset>
                                                    <legend>Edit Material </legend>
                                                    <table width="100%">
                                                      <tr>
                                                        <td width="33%" align="left" class="tblabel">Course:</td>
                                                        <td width="67%" valign="top"><input name="course" type="text" id="course" value="<?php echo $material['course'];?>" disabled="disabled"/></td>
                                                      </tr>
                                                      <tr>
                                                        <td width="33%" align="left" class="tblabel">Number of Pages:</td>
                                                        <td width="67%"><input name="pages" type="text" id="pages" onkeyup="getTotal();" value="<?php echo $material['pages'];?>"/></td>
                                                      </tr>
                                                      <tr>
                                                        <td width="33%" align="left" class="tblabel">Price per page</td>
                                                        <td width="67%"><input name="price" type="text" id="price" onkeyup="getTotal();" value="<?php echo $material['price_page'];?>"/></td>
                                                      </tr>
													  
													  <tr>
                                                        <td width="33%" align="left" class="tblabel"><br />Cost of Material:</td>
                                                        <td width="67%"><br /><input type="text" name="totalcost" id="totalcost" disabled="disabled" value="<?php echo $material['total'];?>"/><input type="hidden" name="mat_id" id="mat_id" value="<?php echo $material['material_id'];?>"/></td>
                                                      </tr>
                                                    </table>
                                                    </fieldset>
                                                      <br />
                                                    </td>
                                                </tr>
                                                <tr>
                                                  <td width="34%">&nbsp;</td>
                                                  <td width="66%"><input type="submit" title="Save changes" name="save" id="save" value="Apply Changes"/></td>
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
						  <div id="right_below">&nbsp;</div>
						  </td>
						</tr>
					</table>
					<div id="footer"><?php include("footer.php"); ?></div>
				</div>
		</div>
</div>
</center></body>
</html>
