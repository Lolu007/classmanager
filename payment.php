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
		if(isset($_POST['pay']))
		{
			$info = $class->payForMaterial();
		}	
		
		//for current logged in admin
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);
		
		$materialid  = $_GET['materialId'];
		$query="SELECT * FROM materials_sale WHERE material_id='$materialid'";
		$material = $db->fetchData($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::MAKING PAYMENT</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<script language="javascript" src="javascript/functions.js"></script>

<script language="javascript" src="Suggest/js/jquery.js"></script>
<script language="javascript" src="Suggest/js/script.js"></script>
<link href="Suggest/css/style.css" rel="stylesheet" type="text/css">

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
						 <!--  td for centre content-->
						 <td width="60%" valign="top">
						 	<form id="payform" name="payform" method="post" action="">
                                              <table width="100%" border="0" cellpadding="4" cellspacing="4">
                                                <tr>
                                                  <td colspan="2" align="left"><div id="hdline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment for  Materials </div></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="2" align="left"><div id="info"></div></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td colspan="2">
															<fieldset>
															<legend>Payment Details </legend>
															<table width="100%">
															  <tr>
																<td width="33%" align="left" class="tblabel">Course:</td>
																<td width="67%" valign="top"><input name="course" type="text" id="course" value="<?php echo $material['course'];?>" disabled="disabled"/><input type="hidden" name="mat_id" id="mat_id" value="<?php echo $material['material_id'];?>"/></td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Number of Pages:</td>
																<td width="67%"><input name="pages" type="text" id="pages" value="<?php echo $material['pages'];?>" disabled="disabled"/></td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Price per page</td>
																<td width="67%"><input name="price" type="text" id="price" onkeyup="getTotal();" value="<?php echo $material['price_page'];?>" disabled="disabled"/></td>
															  </tr>
															  
															  <tr>
																<td width="33%" align="left" class="tblabel"><br />Cost of Material:</td>
																<td width="67%"><br /><input type="text" name="totalcost" id="totalcost" disabled="disabled" value="<?php echo $material['total'];?>"/></td>
															  </tr>
															</table>
															</fieldset>
                                                      <br />
                                                    </td>
                                                </tr>
												
												<!---->
													<tr>
                                                  <td colspan="2">
															<fieldset>
															<legend>Making Payment  </legend>
															<table width="100%">
															  <tr>
																<td width="33%" align="left" class="tblabel">Matric Number: </td>
																<td width="67%" valign="top">
																	<div class="main"> <div id="holder">
																   <input type="text" name="keyword"  tabindex="0" id="keyword" value="<?php echo $_POST['keyword'];?>"/>
																   <br />
																  <img src="images/load.gif" name="loading" id="loadin" /></div>
																	<div id="ajax_response"></div>
																  </div>
																 </td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Amount collected:</td>
																<td width="67%"><input name="amountpaid" type="text" id="amountpaid" value="<?php echo $_POST['amountpaid']; ?>" onkeyup="getBalance();"/></td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Balance to be paid:</td>
																<td width="67%"><input name="balance" type="text" id="balance" disabled="disabled"/></td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Change:</td>
																<td width="67%"><input name="change" type="text" id="change" disabled="disabled"/></td>
															  </tr>
															</table>
															</fieldset>
                                                      <br />
                                                    </td>
                                                </tr>
												
												<!---->
                                                <tr>
                                                  <td width="34%">
                                                  		<a href="viewmaterials.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>" title="View students collecting change">&lt;&lt; Back to Materials</a>
                                                  </td>
                                                  <td width="66%"><input type="button" title="Make payment Now!" name="pay" id="pay" value="Pay Now " onclick="payForMaterial('payform','ajax/ajax_request.php','info');"/></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="2"><hr />
                                                    &nbsp;</td>
                                                </tr>
                                              </table>
                                          </form>
						 
						 </td>
						 <!--  td for centre content ends here-->
						 
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
