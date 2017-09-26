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
		
		$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM payments WHERE material_Id = '".$_GET['materialId']."'order by collected asc",64,3);
		$rs = $pager->paginate();
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
		$materialid  = $_GET['materialId'];
		$query="SELECT * FROM materials_sale WHERE material_id='$materialid'";
		$material = $db->fetchData($query);
		
		if($_GET['status'] == 0)
		{
				mysql_query("UPDATE payments SET collected = 1 WHERE student_matric = '".$_GET['matric']."' AND material_Id = '".$_GET['materialId']."'") or die(mysql_error());
				
		}
		else
		{
			mysql_query("UPDATE payments SET collected = 0 WHERE student_matric = '".$_GET['matric']."' AND material_Id = '".$_GET['materialId']."'") or die(mysql_error());
				
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::VIEW STUDENTS THAT HAVE PAID FOR THIS MATERIAL</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>
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
						  		</div>							</td>
						  <td width="75%" valign="top">
						  <table width="100%" cellpadding="2" cellspacing="1">
                            <tr>
                              <td colspan="9">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="9" align="center"><div id="commonhdn"><font color="#006600">LIST OF STUDENTS THAT BOOKED OR PAID FOR THE MATERIAL - <strong><?php echo $material['course']; ?></strong></font></div></td>
                            </tr>
                            <tr>
                              <td colspan="9"><hr /></td>
                            </tr>
                           
                            <tr>
                              <td colspan="9" align="center">
                               <table width="100%">
                               		<tr>
                                    	<td width="18%"><a href="allbalance.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>" title="View students paying balance">View balance</a></td>
                                      <td width="22%"><a href="allchange.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>" title="View students collecting change">View change</a></td>
                                        <td width="60%"><a href="viewmaterials.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>" title="View students collecting change">&lt;&lt; Back to Materials</a></td>
                                    
                                 </tr>
                               </table>
                              </td>
                            </tr>
                             <tr>
                              <td colspan="9"><hr /></td>
                            </tr>
                            <tr align="center" valign="middle" class="tableheader">
                              <td width="3%"><span class="style9">S/N</span></td>
                              <td width="10%"><span class="style9">COURSE</span></td>
							  <td width="7%"><span class="style9">MATRIC NO </span></td>
							  <td width="21%">NAMES</td>
							  <td width="10%"><span class="style9">AMOUNT PAID (NAIRA) </span></td>
							  <td width="11%"><span class="style9">BALANCE(NAIRA)</span></td>
                              <td width="11%"><span class="style9">CHANGE(NAIRA)</span></td>
							  <td width="16%"><span class="style9">DATE PAID</span></td>
                              <td width="11%"><span class="style9">COLLECTED</span></td>
                            </tr>
                            <?php 
								  		$i = 0; 
										$totalpd = 0;
										$totalCh = 0;
										$totalBal = 0;
										while($row = $pager->fetchArray($rs))
										{
											$totalpd+=$row['amount_paid'];
											$totalBal+=$row['balance'];
											$totalCh+=$row['s_change'];
											$qry_mat="SELECT * FROM classmembers WHERE matricNo='".$row['student_matric']."'";
											$std = $db->fetchData($qry_mat);
											if($i%2 == 0)
											{
												  $class = "t1";
												  $i++;
											}
											else
											{
												$class = "t2";
												$i++;
											}
									?>
                            <tr class="<?php echo $class;?>">
                              <td align="center" valign="top"><?php echo $i; ?></td>
							  <td align="center" valign="middle"><a href="editmaterial.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>" title="Manage this material" target="_new"><?php echo $material['course']; ?></a></td>
                              <td align="center" valign="middle"><span><a href="editstudent.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>&amp;matric=<?php echo $row['student_matric']; ?>" title="Manage this student's payment" target="_new"><?php echo $row['student_matric']; ?></a></span></td>
							  <td align="left" valign="middle"><span class="style9"><?php echo strtoupper($std['fname'])." ".strtoupper($std['lname']); ?></span></td>
                              
							  <td align="center" valign="middle"><span class="style2"><?php echo $row['amount_paid'].".00"; ?></span></td>
							  <td align="center" valign="middle"><span class="style2"><?php echo $row['balance']; ?></span></td>
                              <td align="center" valign="top"><span class="style2"><?php echo $row['s_change']; ?></span></td>
							  <td align="center" valign="middle"><span class="style6"><?php echo date("l jS M Y g:i a",$row['datepaid']); ?></span></td>							
                              <td align="center">
                              <a href="viewpayment.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $material['material_id'];?>&amp;matric=<?php echo $row['student_matric']; ?>&amp;status=<?php echo $row['collected']; ?>" class="style7">
                                <?php 
									if($row['collected'] == 0 )//|| $row['collected'] == "")
									{
										echo "<font color='#FF0000'>NO</font>";
									}
									else echo "<font color='#006600'>YES</font>";
								?>
                                </a>
                             </td>
                            </tr>
						    <?php }//end while ?>
                            <tr>
                              <td align="left" valign="top" colspan="8"></td>
                             </tr>
                            <tr>
                              <td align="left" valign="top" colspan="2"><span class="pagination">
                                <?php  if($pager->countRows()>0){echo $pager->renderFullNav();}?>
                              </span> </td>
                              <td>&nbsp;</td><td>&nbsp;</td><td align="center" valign="middle" bgcolor="#006600"><?php echo $totalpd;?></td><td align="center" bgcolor="#FF0000"><?php echo $totalBal;?></td><td align="center" bgcolor="#99CC99"><?php echo $totalCh;?></td><td colspan="2">&nbsp;</td>
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
