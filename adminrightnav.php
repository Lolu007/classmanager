<?php
		
		$db2 = new DBConn2();
		$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM admin where adminId!='".$_SESSION['adminId']."'",30,3);
		$rs = $pager->paginate();
?>
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
.style3 {color: #FF9933}
-->
</style>


<div id="superRightNav">
<form action="" method="post" name="admin" id="admin">
<table width="100%" cellspacing="1" cellpadding="0">
	<tr>
		<td colspan="2" align="right">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="right">&nbsp;</td>
	</tr>
	<tr align="center">
		<td width="46%"><span class="style7 style10 style2">Username</span></td>
		<td width="33%"><span class="style7 style10 style2">Status</span></td>
	</tr>
	<?php
		  $i = 0; 
		  while($row = $pager->fetchArray($rs)){
		
		  if($i%2 == 0) {
		  $class = "t1";
		  $i++;
		  }
		  else
		  {
			$class = "t2";
			$i++;
		  }?>
	
	<tr align="center" bgcolor="#FF9933" class="<?php echo $class;?>">
	  <td><a href="#" title="View <?php echo $row['username']."'s details"; ?>"><span class="style7 style7 style6 style6 style3"><?php echo $row['username'];?></span></a></td>
	  <td><span class="style7 style7 style6 style6 style3"><?php 
	  	if($row['status']==1)
	  		echo "Super Admin";
			else if($row['status']==2)
				echo "Admin";
				
				else echo "Inactive";
			?></span></td>
	 </tr>
	 
	 <?php } ?>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
  </tr>
</table>
</form>
</div>