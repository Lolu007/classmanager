<?php

	//calendar.php
	//Check if the month and year values exist
	if((!$_GET['month']) && (!$_GET['year']))
	{
		$month = date ("n");
		$year = date ("Y");
	}
	else
	{
		$month = $_GET['month'];
		$year = $_GET['year'];
	}
	
	//Calculate the viewed month
	$timestamp = mktime (0, 0, 0, $month, 1, $year);
	$monthname = date("F", $timestamp);
	//Now let's create the table with the proper month

	
	//birthday today...
	$today = date("F j",time());
	$pager = new PS_Pagination($db2->getConnection(),"SELECT * FROM classmembers WHERE dob = '$today' order by lname desc",10,3);
	$rs = $pager->paginate();
	$sum=mysql_num_rows($rs);
	
?>
<style type="text/css">
<!--
.style1 {
	font-size: 11px;
	color: #FF0000;
}
-->
</style>


<table style="width: 105px; border-collapse: collapse;" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000">
	<tr style="background: #FFBC37;">
		<td colspan="7" style="text-align: center;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;"><?php echo $monthname. " " . $year; ?></span>		</td>
	</tr>
	<tr style="background: #FFBC37;">
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'">
	<span style="font-weight: bold;">Su</span>		</td>
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;">M</span>		</td>
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;">Tu</span>		</td>
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;">W</span>		</td>
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;">Th</span>		</td>
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;">F</span>		</td>
		<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#FECE6E'" onmouseout="this.style.background='#FFBC37'"><span style="font-weight: bold;">Sa</span>		</td>
	</tr>
	<?php
		$monthstart = date("w", $timestamp);
		$lastday = date("d", mktime (0, 0, 0, $month + 1, 0, $year));
		$startdate = -$monthstart;
		//Figure out how many rows we need.
		$numrows = ceil (((date("t",mktime (0, 0, 0, $month + 1, 0, $year))
		+ $monthstart) / 7));
		//Let's make an appropriate number of rows...
		for ($k = 1; $k <= $numrows; $k++)//for 1
		{
	?>
	<tr>
	<?php
		//Use 7 columns (for 7 days)...
		for ($i = 0; $i < 7; $i++)//for 2
		{
			$startdate++;
			if(($startdate <= 0) || ($startdate > $lastday))
			{
				//If we have a blank day in the calendar.
	?>
				<td style="background: #FFFFFF;">&nbsp;</td>
	<?php
			}
			else//2
			{
				if ($startdate == date("j") && $month == date("n") && $year == date("Y"))
				{
	?><td style="text-align: center; background: #FFBC37;" onmouseover="this.style.background='#FECE6E'"
	onmouseout="this.style.background='#FFBC37'"><?php echo date ("j"); ?>	  
      <!--<span class="style1"><?php //manipulate this column for today's birthday
				/*if($sum==0)
				{
					echo "No birthday today";
				}
				else 
				{
					echo $res['fname'];
				}*/
			?>
	</span>-->
    </td>
	<?php
				}//end if
				else//3
				{
	?>				<td style="text-align: center; background: #A2BAFA;" onmouseover="this.style.background='#CAD7F9'"onmouseout="this.style.background='#A2BAFA'">
	<?php echo $startdate; ?>
					</td><?php
				}//end else3
			}//end else2
		}//end for2
	?></tr><?php
	}//end for 1
	?>
    
    
</table>
<table>
<tr><td><?php 
				if($sum==0)
				{
					echo "No birthday today";
				}
				else 
				{
					echo "Today's birthday <br>";
					while($row = $pager->fetchArray($rs))
					{
					   echo $row['fname']."<br>";
					}//end while
				}?>
	  </td></tr>
</table>
