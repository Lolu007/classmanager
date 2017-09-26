<script language="javascript">
<!--
	$(document).ready(function(){
		$(".showadAr").click(function(e){
			$("#adminarea").slideDown();
			$("#sett").slideUp();
			$("#class").slideUp();
			$("#materials").slideUp();
		});
		
		$(".classsetting").click(function(e){
			$("#sett").slideDown();
			$("#adminarea").slideUp();
			$("#class").slideUp();
			$("#materials").slideUp();
		});
		
		$(".manageclass").click(function(e){
			$("#class").slideDown();
			$("#sett").slideUp();
			$("#adminarea").slideUp();
			$("#materials").slideUp();
		});
		
		$(".showmaterials").click(function(e){
			$("#materials").slideDown();
			$("#class").slideUp();
			$("#sett").slideUp();
			$("#adminarea").slideUp();
		});
	});
//-->
</script>
<style type="text/css">
<!--
#adminarea {
	display: none;
}
#sett {
	display: none;
}
#class {
	display: none;
}
.manageclass {
	font-weight: bold;
}
.classsetting {
	font-weight: bold;
}
.showadAr {
	font-weight: bold;
}
.showmaterials {
	font-weight: bold;
	display: inline;
}
#materials {
	display: none;
}
.submenu {
	color: #FF3300;
}
-->
</style>


<ul>
	<li><table><tr><td width="30" align="left"><img src="images/icons/home.png" /></td>
	<td width="60" align="left" valign="middle"><a href="home.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Admin panel Home">Home</a></td>
	</tr></table></li>
    
    <li><table><tr><td width="30" align="left"><img src="images/icons/home.png" /></td>
	<td width="60" align="left" valign="middle"><a href="timetable.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>" title="Manage Time-Table">Time Table</a></td>
	</tr></table></li>
	
	<li><a href="#" class="manageclass" title="Manage Class">Manage Class</a></li>
	
	<div id="class">
	<li><table>
	  <tr><td width="30" align="left"><img src="images/icons/home.png" /></td>
	<td width="121" align="left" valign="middle"><a href="viewclass.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>" title="View Class"><div class="submenu">Class Members</div></a></td>
	</tr></table></li>
	
	<li><table><tr><td width="30" align="left"><img src="images/icons/newmember.png" /></td><td width="110" align="left" valign="middle"><a href="addclassmember.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Add student"><div class="submenu">Add Student</div></a></td>
	</tr></table></li>
    
    <li><table><tr><td width="30" align="left"><img src="images/icons/newmember.png" /></td><td width="110" align="left" valign="middle"><a href="results.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Manage results"><div class="submenu">Results</div></a></td>
	</tr></table></li>
    
    <li><table><tr><td width="30" align="left"><img src="images/icons/newmember.png" /></td><td width="110" align="left" valign="middle"><a href="birthday.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="View birthdays"><div class="submenu">View birthdays</div></a></td>
	</tr></table></li>
	</div>
	
	<li><a href="#" class="showmaterials" title="Manage Materials">CourseMaterials</a></li>
	<div id="materials">
		<li><table>
	  <tr><td width="30" align="left"><img src="images/icons/home.png" /></td>
	<td width="121" align="left" valign="middle"><a href="coursematerial.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>" title="Create Material for sale">
	<div class="submenu">Create Material</div>
	</a></td>
	</tr></table></li>
	
	<li><table>
	  <tr><td width="30" align="left"><img src="images/icons/home.png" /></td>
	<td width="121" align="left" valign="middle"><a href="viewmaterials.php?adminstatus=<?php echo base64_encode($adminstatus);?>&amp;user=<?php echo base64_encode($user);?>&amp;name=<?php echo base64_encode($name);?>" title="View Available Materials to manage">
	<div class="submenu">Manage Material</div>
	</a></td>
	</tr></table></li>
	
	</div>
	
	<li><a href="#" class="classsetting" title="Settings">Class Settings </a></li>
	 <div id="sett">
	 		<li><table><tr><td width="30" align="left"><img src="images/icons/newmember.png" /></td><td width="110" align="left" valign="middle"><a href="cour.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Manage Courses"><div class="submenu">Courses Settings</div></a></td>
	</tr></table></li>
	
	<li><table><tr><td width="30" align="left"><img src="images/icons/newmember.png" /></td><td width="110" align="left" valign="middle"><a href="hall.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Hall Settings"><div class="submenu">Hall Settings</div></a></td>
	</tr></table></li>
	
	 </div>
	
	
	<li><a href="#" class="showadAr" title="Click to manage admin">Admin Area</a></li>
	<div id="adminarea">
	<?php if($adminstatus==1) { ?>
	<li><table><tr><td width="30" align="left"><img src="images/icons/newmember.png" /></td><td width="110" align="left" valign="middle"><a href="newadmin.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Add new admin"><div class="submenu">Add New Admin</div></a></td>
	</tr></table></li><?php } ?>
	
	<li><table><tr><td width="30" align="left"><img src="images/icons/edit.png" /></td>
	<td align="left" valign="middle"><a href="editprofile.php?adminstatus=<?php echo base64_encode($adminstatus);?>&user=<?php echo base64_encode($user);?>&name=<?php echo base64_encode($name);?>" title="Edit your details"><div class="submenu">Admin Profile</div></a></td>
	</tr></table></li>
	</div>
   
	<li><table><tr><td width="30" align="left"><img src="images/icons/lock.png" width="16" height="16" /></td>
	<td width="60" align="left" valign="middle"><a href="adminlogout.php" title="Logout">Logout</a></td></tr></table></li>
</ul>