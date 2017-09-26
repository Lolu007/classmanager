<?php 
		session_start();
error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(E_ALL ^ E_NOTICE);
		//including the file that contains the AdminManager class
		require_once("classes/adminCodes.php");
		require_once("classes/ps_pagination.php");
		
		$admin = new AdminManager();
		$class = new ClassManager();
		
		$db2 = new DBConn2();
		$db = new DBConn();
		
		$adminstatus = base64_decode($_GET['adminstatus']);
		$user = base64_decode($_GET['user']);
		$name = base64_decode($_GET['name']);
		
		if(!isset($_SESSION['adminId'])&&($_SESSION['logged']!=true))
		{
			header("location:index.php?error=".base64_encode("Unathourized Access, please login"));
		}
		
		$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM courses order by course_code desc",10,3);
		$rs = $pager->paginate();
		
		//getting current admin login details
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);	
		
		if(isset($_POST['btnSave']) && $_POST['btnSave']=='Save')
		{
			if($class->insertHall($_POST['hname']))
					$a = "done";
		}
		
		
		$sql="SELECT * FROM hallofres Order by hall";
		$res=mysql_query($sql) or die(mysql_error());
		$rs=mysql_fetch_assoc($res);
		$numrs=mysql_num_rows($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::MANAGE HALL</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery/jquery.js"></script>

<script language="javascript">
<!--
	$(document).ready(function(){
		$(".newcourse").click(function(e){
			$("#newcourseform").slideDown();
		});
		
		$("#btnCancel").click(function(e){
			$("#newcourseform").slideUp();
		});
	});
//-->
</script>
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
  #newcourseform
	{
		display:none;
		background-color:#ECECFF;
	}
	
	#msg
	{
	font-weight:500;
	background-color:#FFFFCC;
	padding-left: 10px;
	}
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
						  		<div id="inner_content">
									  <div id="pagetitle"><h3>Hall of Residence</h3></div>
									<div id="pagehead"><a href="#">Settings</a> &gt;&gt; Halls of residence</div>
									<table width="100%" border="0" cellspacing="2" cellpadding="2">
									<?php if(isset($a) && $a=="done"){ ?>
									  <tr>
										<td colspan="2"><div id="msg">You have successfully added one hall of residence. <a href="#" class="newcourse">Add another</a></div></td>
									  </tr>
										<?php } ?>
                                        
                                      
									<?php if(!(isset($a) && $a=="done")){ ?>
									  <tr>
									  <tr>  
										<td width="50%"><a href="#" class="newcourse">Add Hall </a></td>
										<td width="50%">&nbsp;</td>
									  </tr>
									  <?php } ?>
									  <tr>
									  <tr>
										<td colspan="2"><div id="newcourseform"><form action="" method="post">
											<table border="0" width="80%" align="center" cellspacing="2" cellpadding="2">
												
												<tr>
												  <td width="17%">Hall Name </td>
												  <td width="83%"><input name="hname" type="text" id="hname" size="60" maxlength="100" /></td>
											  </tr>
												<tr>
												  <td>&nbsp;</td>
												  <td><input name="btnSave" type="submit" id="btnSave" value="Save" />
													<input name="btnCancel" type="button" id="btnCancel" value="Cancel" /></td>
											  </tr>
											</table>
										</form></div></td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									  </tr>
									  <tr>
										<td><strong>Halls of Residence </strong> </td>
										<td>&nbsp;</td>
									  </tr>
									  <tr>
										<td>
										<?php
										if($numrs > 0 ){
											echo "<ul>";
										 //not empty
											do {
												echo "<li>".$rs['hall']."</li>";
											} while ($rs=mysql_fetch_assoc($res));
										
											echo "</ul>";	
										} else //emptu
											echo "No hall of residence has been added yet.";
										?></td>
										<td>&nbsp;</td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									  </tr>
									</table>
						    </div>
									
                          </td>
							<td width="20%" align="left" valign="top" bgcolor="#CCCC00">
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
