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
                              <td colspan="8">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="8" align="center"><div id="commonhdn">AVAILABLE MATERIALS </div></td>
                            </tr>
                            <tr>
                              <td colspan="8" align="center"><?php if($pager->countRows($rs)==0){?>
                                  <div id="action"><?php echo "No material for sales" ;?></div>
                                <?php }?></td>
                            </tr>
                            <tr align="center" valign="middle" class="tableheader">
                              <td><span class="style9">S/N</span></td>
                              <td><span class="style9">COURSE</span></td>
							  <td><span class="style9">NUMBER OF PAGES</span></td>
							  <td><span class="style9">PRICE/PAGES(NAIRA)</span></td>
							  <td><span class="style9">TOTAL COST(NAIRA)</span></td>
							  <td><span class="style9">TOTAL STUDENT(S)</span></td>
                              <td><span class="style9">DATE CREATED </span></td>
							  <td><span class="style9">PAYMENT </span></td>
                            </tr>
                            <?php 
								  		$i = 0; 
										while($row = $pager->fetchArray($rs))
										{
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
							  <td align="center" valign="top"><a href="editmaterial.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $row['material_id'];?>" title="Manage this material"><?php echo $row['course']; ?></a></td>
                              <td align="center" valign="middle"><span class="style2"><?php echo $row['pages']; ?></span></td>
							  <td align="center" valign="middle"><span class="style2"><?php echo $row['price_page'].".00"; ?></span></td>
                              
							  <td align="center" valign="middle"><span class="style2"><?php echo $row['total'].".00"; ?></span></td>
							  <td align="center" valign="middle"><span class="style5"><a href="viewpayment.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $row['material_id'];?>" title="View students that have paid OR booked for this material"><?php echo $row['total_booked']." - (Click to view Students)";?></a></span></td>
                              <td align="left" valign="top"><span class="style6"><?php echo date("l jS M Y g:i a",$row['datecreated']); ?></span></td>
							   <td align="left" valign="top"><span class="style6"><a href="payment.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;materialId=<?php echo $row['material_id'];?>" title="click to add payment for this material">Add Payment</a></span></td>
                            </tr>
						    <?php }//end while ?>
                            <tr>
                              <td align="left" valign="top" colspan="8"><span class="pagination">
                                <?php  if($pager->countRows()>0){echo $pager->renderFullNav();}?>
                              </span> </td>
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
