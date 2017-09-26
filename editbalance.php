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
		$matric = $_GET['stud_matric'];
		
		if(!isset($_SESSION['adminId'])&&($_SESSION['logged']!=true))
		{
			header("location:index.php?error=".base64_encode("Unathourized Access, please login"));
		}
		
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
		$qry = "SELECT * FROM payments WHERE student_matric='$matric'";
		$stud = $db->fetchData($qry);
		
		$materialid  = $_GET['materialId'];
		$query="SELECT * FROM materials_sale WHERE material_id='$materialid'";
		$material = $db->fetchData($query);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::EDITING PAYMENT FOR <?php echo $stud['fname']." ".$stud['lname']; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
<script language="javascript" src="javascript/functions.js"></script>
<style type="text/css">
<!--
.style9 {font-size: 12}
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
						  <td width="75%" valign="top">
						  		<form id="balform" name="balform" method="post" action="">
                                              <table width="100%" border="0" cellpadding="4" cellspacing="4">
                                                <tr>
                                                  <td colspan="2" align="left"><div id="hdline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Editing Balance</div></td>
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
																<td width="33%" align="left" class="tblabel"><br />Cost of Material:</td>
																<td width="67%"><br /><input type="text" name="totalcost" id="totalcost" disabled="disabled" value="<?php echo $material['total'];?>"/></td>
															  </tr>
															</table>
													</fieldset>
                                                      <br />                                                    </td>
                                                </tr>
												
												<!---->
													<tr>
                                                  <td colspan="2">
															<fieldset>
															<legend>Making Payment  </legend>
															<table width="100%">
															  <tr>
																<td width="33%" align="left" class="tblabel">Matric Number: </td>
																<td width="67%" valign="top"><input type="text" name="matric" id="matric" value="<?php echo $stud['student_matric'];?>" disabled="disabled"/>
															    <br/>															    </td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Initail Amount paid:</td>
																<td width="67%"><input name="amountpaid" type="text" id="amountpaid" value="<?php echo $stud['amount_paid']; ?>" disabled="disabled"/></td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Balance to be paid:</td>
																<td width="67%"><input name="balance" type="text"  id="balance" value="<?php echo $stud['balance']; ?>" disabled="disabled"/>
															    <input type="hidden"name="getBal" id="getBal" value="<?php echo $stud['balance']; ?>"/></td>
															  </tr>
                                                              <tr>
																<td width="33%" align="left" class="tblabel">Amount paid now:</td>
																<td width="67%"><input name="balpaid" type="text"  id="balpaid" onkeyup="editBalance();"/><input type="hidden" name="matCost" id="matCost" value="<?php echo $material['total']; ?>"/></td>
															  </tr>
															  <tr>
																<td width="33%" align="left" class="tblabel">Balance to collect:</td>
																<td width="67%"><input name="change" type="text" id="change" value="<?php echo $stud['s_change']; ?>"/></td>
															  </tr>
															</table>
													</fieldset>
                                                      <br />                                                    </td>
                                                </tr>
												
												<!---->
                                                <tr>
                                                  <td width="34%">&nbsp;</td>
                                                  <td width="66%"><input type="button" name="save" id="save" value="Save" onclick="editbal('balform','ajax/ajax_request.php','info');"/></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="2"><hr />
                                                    &nbsp;</td>
                                                </tr>
                                              </table>
                            </form>
						  
						  </td>
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
