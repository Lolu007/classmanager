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
		$db2 = new DBConn2();
		
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
		
		$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM classmembers order by dob desc",10,3);
		$rs = $pager->paginate();
		
		
		//for current logged in admin
		$query="SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'";
		$row = $db->fetchData($query);
		
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::CLASS MANAGER v1.0::Managing birthdays</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="javascript/functions.js"></script>
<script language="javascript" src="javascript/util.js"></script>

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
						 	<form id="btday" name="btday" method="post" action="">
                                              <table width="100%" border="0" cellpadding="4" cellspacing="4">
                                                
                                                <tr>
                                                  <td width="100%" align="left">&nbsp;</td>
                                                </tr>
                                                
                                                <tr>
                                                  <td></td>
                                                </tr>
												
												<!---->
													<tr>
                                                  <td>
															
                                                    <table width="100%">
                                                    <tr><td colspan="2" align="center">Search for birthday<br /><br /></td></tr>
                                                      <tr>
                                                        <td width="33%" valign="top" align="left" class="tblabel">Enter Name or Matric number</td>
                                                        <td width="67%" valign="top">
                                                            <div class="main"> <div id="holder">
                                                           <input type="text" name="keyword"  tabindex="0" id="keyword" value="<?php echo $_POST['keyword'];?>" onkeyup="searchBirthdays();"/>
                                                           <br />
                                                          <img src="images/load.gif" name="loading" id="loadin" /></div>
                                                            <div id="ajax_response"></div>
                                                          </div>
                                                          <br />
                                                          <input type="button" id="go" name="go" value="Search" onclick="searchBirthdays();"/></td>
                                                      </tr>
                                                    </table>													                                                    </td>
                                                </tr>
												
												<!---->
                                                <tr>
                                                  <td height="148"><hr />
                                                  <table><tr><td colspan="6">Search by month:	<select name="month" id="month" onchange="loadBirthdays();"><option value="">-select-</option>                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>                                                 <option value="October">October</option>
                                                        <option value="November">November</option>
                                                       <option value="December">December</option>
                                                        </select><br /><br /></td></tr></table>
                                                  
                                                    <div id="betday">
                                                    	<table width="100%">
                                                        
                                                        	<tr align="center" valign="middle" class="tableheader">
                                                          <td><span class="style9">S/N</span></td>
                                                          <td><span class="style9">NAME</span></td>                                         				<td><span class="style9">DATE OF BIRTH</span></td>
                                                          <td><span class="style9">EMAIL</span></td>										<td ><span class="style9">PHONE</span></td>											<td ><span class="style9">HALL/RMN</span></td>
                                                          
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
							
                              <td align="center" valign="middle"><span class="style5"><?php echo $row['fname']." ".$row['lname']; ?></span></td>
                              <td align="left" valign="middle"><span class="style6"><?php echo $row['dob']; ?></span></td>
							  <td align="left" valign="middle"><span class="style6"><?php echo $row['email']; ?></span></td>
                              <td align="left" valign="middle"><span class="style7"><?php echo $row['phone']; ?></span></td>
                              <td align="left" valign="middle"><span class="style7"><?php echo $hall['hall']."/".$row['roomno']; ?></span></td>
                              
                            </tr>
						    <?php }//end while ?>
                            <tr>
                              <td align="left" valign="top" colspan="8"><span class="pagination">
                                <?php  if($pager->countRows()>0){echo $pager->renderFullNav();}?>
                              </span> </td>
                            </tr>
                                                        
                                                        
                                  </table>
                                </div></td>
                            </tr>
                          </table>
                           </form>
						 
						 </td>
						 <!--  td for centre content ends here-->
						 
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
