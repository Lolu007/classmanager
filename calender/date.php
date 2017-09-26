<title>Date Manipulation</title><?php 

		//echo "day is ".date('d')."</br>";
		//echo "month is ".date('n')."</br>";
		//echo "year is ".date('Y')."</br>";
	
		//echo date("d/n/Y",time());
	 	//time();
	 	//28/09
	 
	 
		//$nextWeek = time() + (7 * 24 * 60 * 60);
//						   // 7 days; 24 hours; 60 mins; 60secs
//						   
//		echo "Now:       	".date("Y-m-d")."</br>";
//		echo "Next Week: 	".date("Y-m-d",$nextWeek)."</br>";
//		// or using strtotime():
//		echo "Next Week: 	". date("Y-m-d", strtotime("+1 week"))."</br></br>";
		
		//special work of strtotime()
		//echo strtotime("now")."----now</br></br>";
//		echo strtotime("10 September 2000")."----10 September 2000</br></br>";
//		echo strtotime("+1 day")."----+1 day</br></br>";
//		echo strtotime("+1 week")."------+1 week</br></br>";
//		echo strtotime("+1 week 2 days 4 hours 2 seconds")."-----+1 week 2 days 4 hours 2 seconds</br></br>";
//		echo strtotime("next Thursday")."------next Thursday</br></br>";
//		echo strtotime("last Monday")."-----last Monday</br></br>";
		
		//Converting entered date of birth to timestamp
		$dobtime = strtotime("28 September");
			
		$today 	= date("d-m",time());//getting today's day and month from current timestamp
		
		//echo $dob."---dob</br></br>";
		echo $today."---today</br></br>";
		
		if(date("d-m",$dobtime)==$today)//comparing dob entered timestamp with today's day and month time stamp
		{
			echo "Today is your birthday";	
		}
		
		
?>