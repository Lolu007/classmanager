<?php
		require_once("../classes/dbConnection.php");
		require_once("../classes/ps_pagination.php");
		
		$db = new DBConn();
		$db2 = new DBConn2();
		
		if($_GET['type']=="days")
		{
			
			$month = $_GET['month'];
			
			if($month=="January" || $month=="March" || $month=="May" || $month=="July" || $month=="August" || $month=="October" || $month=="December" )
			{		
				for($i=1;$i<=31;$i++)
				{
					$days.="<option value='$i'>$i</option>";
				}
				echo $days;
						
			}			
		
			elseif($month=="April" || $month=="June" || $month=="September" || $month=="November")
			{			
				for($i=1;$i<=30;$i++)
				{
					$days.="<option value='$i'>$i</option>";
				}
				echo $days;
			}			
			
			else //february
			{
				for($i=1;$i<=29;$i++)
				{
					$days.="<option value='$i'>$i</option>";
				}
				echo $days;
	
			}//else
			
		}//end if
		
		elseif($_GET['type']=="brthdays")
		{
			
			$month = $_GET['month'];
			
			
			
			$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM classmembers WHERE dob LIKE '$month%' order by lname desc",10,3);
		$rs = $pager->paginate();
		$sum=mysql_num_rows($rs);
			
		

?>
<?php if($sum!=0){?>

<table width="100%">
	<tr><td colspan="6"><?php echo "You have ".$sum." Student(s) born in the month of ".$month; ?></td></tr>
    <tr align="center" valign="middle" class="tableheader">
     <td><span class="style9">S/N</span></td>
     <td><span class="style9">NAME</span></td>
     <td><span class="style9">DATE OF BIRTH</span></td>
     <td><span class="style9">EMAIL</span></td>
     <td ><span class="style9">PHONE</span></td>
     <td ><span class="style9">HALL/RMN</span></td>
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
                              <td align="left" valign="top" colspan="6"><span class="pagination">
                                <?php  if($pager->countRows()>0){echo $pager->renderFullNav();}?>
                              </span> </td>
                            </tr>                    
                              </table><?php } ?>
       
       					<?php if($sum==0){?><table width="100%">
                                <tr>
                                      <td>No student was born in the month of<?php echo " ".$month;?></td>
                                </tr></table>
                                <?php }?>  
       <?php }//end elseif?>
       
       
       <?php
       		if($_GET['type']=="search")
			{
			
				$data = $_GET['keyword'];
			
				$qry = "SELECT * FROM classmembers WHERE matricNo = '$data' ";
				
				$row = $db->fetchData($qry);
				$sum2=$db->getNumOfRows($qry);
				
		?>
        
        <?php if($sum2!=0){?>
        	<table width="100%">
                                                        
                                                        	<tr align="center" valign="middle" class="tableheader">
                                                          
                                                          <td><span class="style9">NAME</span></td>                                         				<td><span class="style9">DATE OF BIRTH</span></td>
                                                          <td><span class="style9">EMAIL</span></td>										<td ><span class="style9">PHONE</span></td>											<td ><span class="style9">HALL/RMN</span></td>
                                                          
                                                        </tr>
                                                        
                                                        <?php 
								  	
										
											$sql="SELECT * FROM hallofres WHERE hallcode='".$row['hallofres']."'";
											$hall = $db->fetchData($sql);
									?>
                            <tr class="t1">
                              
							
                              <td align="center" valign="middle"><span class="style5"><?php echo $row['fname']." ".$row['lname']; ?></span></td>
                              <td align="left" valign="middle"><span class="style6"><?php echo $row['dob']; ?></span></td>
							  <td align="left" valign="middle"><span class="style6"><?php echo $row['email']; ?></span></td>
                              <td align="left" valign="middle"><span class="style7"><?php echo $row['phone']; ?></span></td>
                              <td align="left" valign="middle"><span class="style7"><?php echo $hall['hall']."/".$row['roomno']; ?></span></td>
                              
                            </tr>
                                                                               
                                  </table><?php }?> 
                                  
                                  <?php if($sum2==0){?><table width="100%">
                                <tr>
                                      <td>No student with matric Number <strong><?php echo $data." "; ?></strong>in this class</td>
                                </tr></table>
                                <?php }?>  
			
		<?php }?>     