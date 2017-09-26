<?php 
		session_start();
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
		
		$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM classmembers order by matricNo asc",70,3);
		$rs = $pager->paginate();
		
		
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
		$male = $db->getNumOfRows("SELECT * FROM classmembers WHERE sex='male'");
		$fmale = $db->getNumOfRows("SELECT * FROM classmembers WHERE sex='female'");
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::VIEW CLASS</title>
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
                              <td colspan="8" align="center"><div id="commonhdn">REGISTERED CLASS MEMBERS &nbsp;&nbsp;&nbsp;&nbsp;<a href="addclassmember.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Add student"><blink>Add Student!</blink></a></div></td>
                            </tr>
                            <tr>
                              <td colspan="8" align="left">
                              	<table width="40%">
                   	  <tr>
                       	<td width="40%"><span class="style7">Total Male:&nbsp;&nbsp;<?php echo $male; ?></span></td>
                        <td width="60%"><span class="style7">Total Female:&nbsp;&nbsp;<?php echo $fmale; ?></span></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr align="center" valign="middle" class="tableheader">
                              <td width="4%"><span class="style9">S/N</span></td>
                              <td width="11%"><span class="style9">MATRIC NO.</span></td>
                              <td width="31%"><span class="style9">NAME</span></td>
							  <td width="5%" ><span class="style9">SEX</span></td>
                              <td width="17%"><span class="style9">EMAIL</span></td>
                              <td width="10%"><span class="style9">PHONE</span></td>
							  <td width="12%" ><span class="style9">HALL/RMN</span></td>
                              <td width="10%"><span class="style9">DATE ADDED </span></td>
                            </tr>
                            <?php 
								  		$i = 0; 
										while($row = $pager->fetchArray($rs))
										{
											$sql="SELECT * FROM hallofres WHERE hallcode='".$row['hallofres']."'";
											$hall = $db->fetchData($sql);
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
							  <td align="center" valign="top"><a href="editstudent.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>&amp;matric=<?php echo $row['matricNo']; ?>" title="View <?php echo $row['matricNo']."'s details"; ?>" target="_new"><?php echo $row['matricNo']; ?></a></td>
                              <td align="left" valign="middle" class="style2"><span><?php echo strtoupper($row['fname'])." ".strtoupper($row['mname'])." ".strtoupper($row['lname']); ?></span></td>
                              <td align="left" valign="middle"><span class="style6"><?php echo $row['sex']; ?></span></td>
							  <td align="left" valign="middle"><span class="style6"><?php echo $row['email']; ?></span></td>
                              <td align="left" valign="middle"><span class="style7"><?php echo $row['phone']; ?></span></td>
                              <td align="left" valign="middle"><span class="style7"><?php echo $hall['hall']."/".$row['roomno']; ?></span></td>
                              <td align="left" valign="top"><span class="style6"><?php echo date("l jS M Y g:i a",$row['dateadded']); ?></span></td>
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
