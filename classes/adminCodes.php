<?php
		require_once("dbConnection.php");
		require_once("common.php");
		
class AdminManager
{	

		var $db;
		
		public function __construct()
		{
			$this->db=new DBConn();
			
		}
		
		public function adminDetails()
		{
			$rs=$this->db->fetchData("SELECT * FROM admin WHERE adminId='".$_SESSION['adminId']."'");
			return $rs;
		}
		
		public function editAdmin()
		{
			
			$username = $_POST['adminuser'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			
			$errormsg="";
			//to validate email
			$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			
			if($username=="")
			{
				$errormsg.="Username is empty<br>";
			}
			if(!empty($username) && strlen($username) < 6)
			{
				$errormsg.="Username is too short!<br>";
			}
			
			if($password=="")
			{
				$errormsg.="Password is empty<br>";
			}
			if(!empty($password) && strlen($password) < 6)
			{
				$errormsg.="Password is too short!<br>";
			}
			if($password != $password2)
			{
				$errormsg.="Passwords does not match<br>";
			}
			
			if($name=="")
			{
				$errormsg.="Name field is empty<br>";
			}
			
			if(empty($email) || (!preg_match($regexp, $email)))
			{
				$errormsg.="Invalid email address.<br>";
			}
			
			if (strlen($phone)!=11 || !preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone))
			{
				$errormsg.="The telephone number you entered is invalid.<br>";
			} 
			
			if(!empty($errormsg))
			{	
				return $report=$this->setError($errormsg);
				
			}
			else//1
			{
					$adminDet = AdminManager::adminDetails();
					if(!$this->validateAdmin($username,$password))//if this return false then no such user add the guy
					{
					
							$query = "UPDATE admin SET ";
							$query .=" adminId='".$_SESSION['adminId']."'"; 
							if(!empty($username) && strcmp($username,$adminDet['username'])!=0)
							{
								$query.=", username='$username'";
								$m .= "Username<br>";
							}
							
							if(!empty($password) && strcmp($password,$adminDet['password'])!=0 && strcmp($password,$password2)==0)
							{
								$query.=", password='".md5($password)."'";
								$m.= "Password<br>";
							}
							if(!empty($name) && strcmp($name,$adminDet['name'])!=0)
							
							{
								$query.=", name='$name'";
								$m .= "Name<br>";
							}
							
							if(!empty($phone) && strcmp($phone,$adminDet['phone'])!=0)
							{
								$query.=", phone='$phone'";
								$m .= "Phone Number<br>";
							}
							if(!empty($email) && strcmp($email,$adminDet['email'])!=0)
							{
								$query.=", email='$email'";
								$m .= "Email Address<br>";
							}
							
							$query.=" where adminId='".$_SESSION['adminId']."'";
							//echo $query;
							mysql_query($query)or die(mysql_error());
							if(!empty($m))
							{	
								//session_destroy();
								session_start();
error_reporting(E_ALL ^ E_NOTICE);
								
								return $this->setSuccess("<b>The following data was successfully changed</b> <br>".$m);
							}
							else
							{	
								return $this->setSuccess("You did not edit any of your information ");
							}
						}//end if
						else
						{
							return $this->setError("Username already exist!");
						}	
			}//else1
		}//end editAdmin
		public function newAdmin()
		{
			$username = $_POST['adminuser'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$status=$_POST['admintype'];
			
			$errormsg="";
			//to validate email
			$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			
			if($username=="")
			{
				$errormsg.="Username is empty<br>";
			}
			if(!empty($username) && strlen($username) < 6)
			{
				$errormsg.="Username is too short!<br>";
			}
			
			if($password=="")
			{
				$errormsg.="Password is empty<br>";
			}
			if(!empty($password) && strlen($password) < 6)
			{
				$errormsg.="Password is too short!<br>";
			}
			if($password != $password2)
			{
				$errormsg.="Passwords does not match<br>";
			}
			
			if($name=="")
			{
				$errormsg.="Name field is empty<br>";
			}
			
			if(empty($email) || (!preg_match($regexp, $email)))
			{
				$errormsg.="Invalid email address.<br>";
			}
			
			if (strlen($phone)!=11 || !preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone))
			{
				$errormsg.="The telephone number you entered is invalid.<br>";
			} 
			
			if(!empty($errormsg))
			{	
				return $report=$this->setError($errormsg);
				
			}
			else//1
			{		
					if(!$this->validateAdmin($username,$password))//if this return false then no such user add the guy
					{
						
						$createdById=$_SESSION['adminId'];//setting the user creating new user
						$adminid = time().substr(md5($email),0,17);
					
						$sql=sprintf("INSERT INTO admin (id,adminId,username,password,name,email,phone,createdBy,status,datecreated) VALUES ('','$adminid','$username','".md5($password)."','$name','$email','$phone','$createdById','$status','".time()."')");
						
						if($this->db->executeQuery($sql))
						{
							return $this->setSuccess("<br>New user added successfully!<br>"); //1;insertion was successful				
						}
						else//2
						{
							return 0;		//insertion was not successful
						}//end else2	
					}//end if
					
					else//3 else it returns true, the user exist...
					{
						return $this->setError("Username already exist!");
					}//end else3
					
				}//end else1
				
		}//end function newAdmin
		
		public function adminLogin()
		{
			
			$username = $_POST['adminuser'];
			$password = $_POST['adminpass'];
			
			$errors="";
			if(empty($username) || empty($password))
			{
				$errors.="Username/or password not entered!<br>";
			}
			
			if(!empty($errors))
			{
				return $this->setError($errors);
			}
			
			else//1
			{
				$sql = "SELECT * FROM admin WHERE username='$username' AND password='".md5($password)."'";
				$res = $this->db->fetchData($sql);
				//checking user authentication
				if($this->validateAdmin($username,$password) && ($res['status'] != 3))//if it returns true user exist and user activated 
				{	//allow access
					$_SESSION['adminId']=$res['adminId'];
					$_SESSION['logged']=true;
					
					header("location:home.php?user=".base64_encode($res['username'])."&name=".base64_encode($res[name])."&adminstatus=".base64_encode($res['status']));
				}
				else//2
				{
					
					if($res['status'] == 3)
					{
						return $this->setError("This user has not been activated!");
					}
					else//3
					{
						return $this->setError("Invalid Login details!");
					}//3
					
				}//2
				
			}//1
			
		}//end adminLog
	
		function adminLogout()
		{
			//unset the variables
			//session_destroy();
			unset($_SESSION['adminId']);
			unset($_SESSION['logged']);
			//session_start();
error_reporting(E_ALL ^ E_NOTICE);
			header("location:index.php?out=".base64_encode("You have logged out successfully!").$_SESSION['adminId']);
		}
		
		function validateAdmin($username,$password)
		{
			$sql = "SELECT * FROM admin WHERE username='$username' AND password='".md5($password)."'";
			
			$res = $this->db->getNumOfRows($sql);
			if($res==0)
			{
				return false;//no such user
				
			}
			else
			{
				return true;//user exist
			}	
			
		}
		public function setError($errormsg)
		{
			return "<div id='errorbox'><table width='100%' cellpadding='0' cellspacing='0'>".
		"<tr bgcolor='white'><td width='32'><img src='images/icons/error.png'></td><td><font color='red'><strong>Sorry, the following error(s) occured</strong></font></td></tr>".
		"<tr><td colspan='2'><font color='white' size='-1'>".$errormsg."</font></td></tr></table></div>";
		}//end function setError()
		
		public function setSuccess($successmsg)
		{
				return "<div id='sucbox'><table width='100%' cellpadding='0' cellspacing='0' align='center'>"."<tr bgcolor='#3399FF'><td  width='32'><img src='images/icons/info.png'></td><td><font color='white'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Successfull!</strong></font></td></tr>".
			"<tr><td colspan='2'><div class='success'>".$successmsg."</div></td></tr></table></div>";
		}//end function setSuccess()
		
		
}//end class AdminManager



class ClassManager
{	

		var $db;
		var $admin;
		public function __construct()
		{
			$this->db = new DBConn();
			$this->db2 = new DBConn2();
			$this->admin = new AdminManager();
		}
		
		function treatRequest()
		{
			$typeOfRequest = $_GET['type'];
			
			switch ($typeOfRequest)
			{
				case "register":
					return $this->registerMember();
					break;
					
				case "editstud":
					return $this->editStud();
					break;
					
				case "payment":
					return $this->payForMaterial();
					break;
					
				case "editpayment":
					return $this->editPayment();
					break;
					
				case "editbal":
					return $this->editbal();
					break;
					
			  case "results":
					return $this->addResults();
					break;
			}
		}//end treatRequest
		
		function addResults()
		{
			$matric = $_GET['matric'];
			$cgpa = $_GET['cgpa'];
			
			$sql = "INSERT INTO results VALUES('$matric','$cgpa','".time()."')";
			
			$res = $this->db>executeQuery($sql);
		}
		
		function checkMatric($matric)
		{
			$sql = "SELECT * FROM classmembers WHERE matricNo='$matric'";
			
			$res = $this->db->getNumOfRows($sql);
			if($res==0)
			{
				return false;//no such user
				
			}
			else
			{
				return true;//user exist
			}	
			
		}
		
		public function getStudent($matric)
		{
			$qry = "SELECT * FROM classmembers WHERE matricNo ='$matric'";
			
			$std = $this->db->fetchData($qry);
			
			return $std;
		}
		
		public function editStud()
		{
			
			$matric = $_GET['matric'];
			$fname  = $_GET['fname'];
			$mname  = $_GET['mname'];
			$lname  = $_GET['lname'];
			$dob  = $_GET['mon']." ".$_GET['days'];
			$sex  = $_GET['gender'];
			$hall  = $_GET['hall'];
			$roomno = $_GET['roomno'];
			$phone = $_GET['phone'];
			$email = $_GET['email'];
			$address = addslashes($_GET['address']);
			$kinname = $_GET['kinname'];
			$kinphone = $_GET['kinphone'];
			
			//$dob = strtotime("$mon $day");
			$report="";
			//to validate email
			$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			if(empty($matric))
			{
				$report.="Matric field is empty!<br>";	
			}
			if(!empty($matric) && (strlen($matric) < 6 || strlen($matric) > 6))
			{
				$report.="You have entered an invalid Matric Number<br>";
			}
			/*if(empty($fname) || empty($lname))
			{
				$report.="Not all the name fields are filled!<br>";
			}
			
			if (strlen($phone)!=11 || !preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone))
			{
				$report.="The telephone number you entered is invalid.<br>";
			} 
			if(empty($email) || (!preg_match($regexp, $email)))
			{
				$report.="Invalid email address.<br>";
			}
			if(empty($hall))
			{
				$report.="Hall of residence not selected<br>";
			}*/
			if(!empty($report))
			{
				return $this->admin->setError($report);
			}
			else//1
			{
					
							$studDet = $this->getStudent($matric);
							
							$query = "UPDATE classmembers SET ";
							$query .=" matricNo='$matric'"; 
							
							if(!empty($fname) && strcmp($fname,$studDet['fname'])!=0)
							{
								$query.=", fname='$fname'";
								$m.= "First Name<br>";
							}
							if(!empty($mname) && strcmp($mname,$studDet['mname'])!=0)
							
							{
								$query.=", mname='$mname'";
								$m .= "Middle Name<br>";
							}
							if(!empty($lname) && strcmp($lname,$studDet['lname'])!=0)
							
							{
								$query.=", lname='$lname'";
								$m .= "Last Name<br>";
							}
							if(!empty($phone) && strcmp($phone,$studDet['phone'])!=0)
							{
								$query.=", phone='$phone'";
								$m .= "Phone Number<br>";
							}
							if(!empty($email) && strcmp($email,$studDet['email'])!=0)
							{
								$query.=", email='$email'";
								$m .= "Email Address<br>";
							}
							if(!empty($dob) && strcmp($dob,$studDet['dob'])!=0)
							{
								$query.=", dob='$dob'";
								$m .= "Birthday<br>";
							}
							if(!empty($sex) && strcmp($sex,$studDet['sex'])!=0)
							{
								$query.=", sex='$sex'";
								$m .= "Sex<br>";
							}
							if(!empty($hall) && strcmp($hall,$studDet['hallofres'])!=0)
							{
								$query.=", hallofres='$hall'";
								$m .= "Hall of residence<br>";
							}
							if(!empty($roomno) && strcmp($roomno,$studDet['roomno'])!=0)
							{
								$query.=", roomno='$roomno'";
								$m .= "Room Number<br>";
							}
							if(!empty($address) && strcmp($address,$studDet['address'])!=0)
							{
								$query.=", address='$address'";
								$m .= "Home Address<br>";
							}
							if(!empty($kinname) && strcmp($kinname,$studDet['nextofkin_name'])!=0)
							{
								$query.=", nextofkin_name='$kinname'";
								$m .= "Next of Kin's name<br>";
							}
							if(!empty($kinphone) && strcmp($kinphone,$studDet['nextofkin_phone'])!=0)
							{
								$query.=", nextofkin_phone='$kinphone'";
								$m .= "Next of Kin's phone number<br>";
							}
							
							$query.=" where matricNo='$matric'";
							//echo $query;
							mysql_query($query)or die(mysql_error());
							if(!empty($m))
							{	
								//session_destroy();
								session_start();
error_reporting(E_ALL ^ E_NOTICE);
								
								return $this->admin->setSuccess("<b>The following data was successfully changed</b> <br>".$m);
							}
							else
							{	
								return $this->admin->setSuccess("Nothing was changed!");
							}
							
			}//else1
		}//end editStud
		public function registerMember()
		{
			$matric = $_GET['matric'];
			$fname  = $_GET['fname'];
			$mname  = $_GET['mname'];
			$lname  = $_GET['lname'];
			$dob  = $_GET['mon']." ".$_GET['days'];
			$sex  = $_GET['sex'];
			$hall  = $_GET['hall'];
			$roomno = $_GET['roomno'];
			$phone = $_GET['phone'];
			$email = $_GET['email'];
			$address = addslashes($_GET['address']);
			$kinname = $_GET['kinname'];
			$kinphone = $_GET['kinphone'];
			
			$report="";
			//to validate email
			$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			if(empty($matric))
			{
				$report.="Matric field is empty!<br>";	
			}
			if(!empty($matric) && (strlen($matric) < 6 || strlen($matric) > 6))
			{
				$report.="You have entered an invalid Matric Number<br>";
			}
			/*if(empty($fname) || empty($lname))
			{
				$report.="Not all the name fields are filled!<br>";
			}
			
			if (strlen($phone)!=11 || !preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone))
			{
				$report.="The telephone number you entered is invalid.<br>";
			} 
			if(empty($email) || (!preg_match($regexp, $email)))
			{
				$report.="Invalid email address.<br>";
			}
			if(empty($hall))
			{
				$report.="Hall of residence not selected<br>";
			}*/
			if(!empty($report))
			{
				return $this->admin->setError($report);
			}
			else//1
			{		
					if(!$this->checkMatric($matric))//if this return false then no such matric add the guy
					{	
						$sql=sprintf("INSERT INTO classmembers (id,matricNo,fname,mname,lname,sex,address,hallofres,roomno,email,phone,dob,nextofkin_name,nextofkin_phone,dateadded) VALUES ('','$matric','$fname','$mname','$lname','$sex','$address','$hall','$roomno','$email','$phone','$dob','$kinname','$kinphone','".time()."')");
						
						if($this->db->executeQuery($sql))
						{
							return $this->admin->setSuccess("<br>Matric number <strong>$matric</strong> added successfully!<br>"); //1;insertion was successful				
						}
						else//2
						{
							return 0;		//insertion was not successful
						}//end else2	
					}//end if
					
					else//3 else it returns true, the user exist...
					{
						return $this->admin->setError("This matric number already exist!");
					}//end else3
					
				}//end else1
			
			
			
		}//end function registerMember()
		
		public function insertHall($hallname)
		{
			/*if(empty($hallname))
			{
				return "You did not enter any hall";
			}*/
			$cd=new UniqueCode("hallofres", "hallcode");
			$hallcode=$cd->getCode();
			
			$sql=sprintf("INSERT INTO hallofres (hallcode, hall, datecreated, lastupdate) VALUES ('%s','%s','%s','%s')", $hallcode, $hallname, time(), time());
					
			if($this->db->executeQuery($sql))
				return 1; // insertion was successful
			else
				return 0;	//insertion was not successful.
		}
		
		public function insertCourse($courselevel, $course, $coursecode)
		{
			
			$sql=sprintf("INSERT INTO courses (coursecode, courselevel, coursetitle, datecreated, lastupdate) VALUES ('%s','%s','%s','%s','%s')", $coursecode, $courselevel, $course, time(), time());
					
			if($this->db->executeQuery($sql))
				return 1; // insertion was successful
			else
				return 0;	//insertion was not successful.
		}
		
		public function editMaterial()
		{
			$mat_id	= $_POST['mat_id'];
			$course = $_POST['course'];
			$pages	= $_POST['pages'];
			$price  = $_POST['price'];//price per page
			
			
			if(empty($pages) || empty($price))
			{
				return $this->admin->setError("Not all the pages are filled!");
			}
			else//1
			{
				$total  = $pages*$price;
				
				$rs=$this->db->fetchData("SELECT * FROM materials_sale WHERE material_id='$mat_id'");
				
							$query = "UPDATE materials_sale SET ";
							
							$query .=" material_id='".$rs['material_id']."'"; 
							
							if(!empty($pages) && strcmp($pages,$rs['pages'])!=0)
							{
								$query.=", pages='$pages'";
								$m .= "Number of pages<br>";
							}
							if(!empty($price) && strcmp($price,$rs['price_page'])!=0)
							{
								$query.=", price_page='$price'";
								$m .= "Price per page<br>";
							}
							if(!empty($total) && strcmp($total,$rs['total'])!=0)
							{
								$query.=", total='$total'";
								$m .= "Total cost of the material<br>";
							}
							
							$query.=" WHERE material_id='".$rs['material_id']."'";
							//echo $query;
							mysql_query($query)or die(mysql_error());
							if(!empty($m))
							{	
								//session_destroy();
								session_start();
error_reporting(E_ALL ^ E_NOTICE);
								
								return $this->admin->setSuccess("<b>The following data was successfully changed</b> <br>".$m);
							}
							else
							{	
								return $this->admin->setSuccess("You did not edit any of your information ");
							}
						
			}//end else1
			
		}//editMaterial
		
		public function createMaterial()
		{
			$course = $_POST['course'];
			$pages	= $_POST['pages'];
			$price  = $_POST['price'];//price per page
			
			$total  = $pages*$price;
			
			$id=time().substr(md5($course.time()),0,17);
			
			$sql=sprintf("INSERT INTO materials_sale (id, material_id, course, pages, price_page, total,total_booked, datecreated) VALUES ('', '$id','$course','$pages','$price','$total','','".time()."')");
			
			if($this->db->executeQuery($sql))
				return $this->admin->setSuccess("You have successfully created a material"); // insertion was successful
			else
				return 0; //insertion was not successful.
		}//createMaterial()
		
		
		public function editPayment()
		{
			$material_Id = $_GET['mat_id'];
			$matric = $_GET['matric'];
			$amount = $_GET['amountpaid'];
			$materialCost = $_GET['totalcost'];
		}
		
		public function editbal()
		{
			$material_Id = $_GET['mat_id'];
			$matric = $_GET['matric'];
			$matCost = $_GET['matCost'];
			
			$inibal = $_GET['balance'];
			$balpaid = $_GET['balpaid'];
			
			if(empty($balpaid))
			{
				return $this->admin->setError("You are not making any balance payment!<br>Please enter balance");
			}
			if($inibal > $balpaid)
			{
				$balance = $inibal - $balpaid;
				$change = 0;
				$fullpay=$matCost;
			}
			else if($inibal < $balpaid && $inibal!=0)
			{
				$change = $balpaid - $inibal;
				$balance = 0;
				$fullpay=$matCost;
				
			}
			
			else
			{
				$balance = 0;
				$change = 0;
				$fullpay=$matCost;
			}
			
			$qry = "UPDATE payments SET s_change='$change', balance='$balance', amount_paid='$fullpay' WHERE student_matric='$matric' AND material_Id='$material_Id'";
			
			$this->db->executeQuery($qry);
						
						if($this->db->executeQuery($qry))
							return $this->admin->setSuccess("Successful"); // insertion was successful
						else
							return 0;	//insertion was not successful.
			
		}
		
		
		public function payForMaterial()
		{
			$material_Id = $_GET['mat_id'];
			$matric = $_GET['keyword'];
			$amount = $_GET['amountpaid'];
			$materialCost = $_GET['totalcost'];
			//$change = $_GET['change'];
			$amt = $amount;
			if(empty($amount))
			{
				$amount = 0;//$err.="You did not enter amount paid<br>";	
			}
			if($materialCost > $amount)
			{
				$balance = $materialCost - $amount;
				$change = 0;
			}
			else if($materialCost < $amount)
			{
				$change = $amount - $materialCost;
				$balance = 0;
			}
			
			else
			{
				$balance = 0;
				$change = 0;
			}
			
			$err = "";
			
			if(empty($matric))
			{
				$err.="You did not enter student making payment<br>";
			}
			
			if(!empty($err))
			{
				return $this->admin->setError($err);
			}
			else//else1
			{
					
					$qry = "SELECT * FROM payments WHERE student_matric='$matric' AND material_Id='$material_Id'";
					
					if($this->db->getNumOfRows($qry) > 0)
					{
						return $this->admin->setError("Payment has been made for this material by Matric <strong>$matric</strong>");
					}
					else//else2
					{
										
						$sql=sprintf("INSERT INTO payments (id, student_matric, material_Id, amount_paid, balance, s_change, datepaid, collected) VALUES ('','$matric','$material_Id','$amount','$balance','$change','".time()."','0')");
						
						$qry = "UPDATE materials_sale SET total_booked = total_booked + '1' WHERE material_id= '$material_Id'";
						$this->db->executeQuery($qry);
						
						if($this->db->executeQuery($sql))
						{
							if(empty($amt))
							{
								return $this->admin->setSuccess("You have successfully booked for <strong>$matric</strong> no payment yet");
							}else
							return $this->admin->setSuccess("You have successfully paid for <strong>$matric</strong>"); // insertion was successful				
						}
						else
							return 0;	//insertion was not successful.
					}//end else2
					
			}//end else1
			
		}//payForMaterial()
		
		public function searchStudent()
		{
				$data = $_POST['data'];
				
				$this->db2->setQuery("SELECT * FROM classmembers WHERE fname LIKE '$data%' OR lname LIKE '$data%' OR matricNo LIKE '$data%' limit 0,20");
				
				if($this->db2->countResultset() > 0)
				{
					$result='<ul class="list">';
				
					while($row = $this->db2->getResultset())
					{
						$str = $row['matricNo'];//." ".$row['fname']." ".$row['lname'];
						$start = strpos($str,$keyword); 
						$end   = similar_text($str,$keyword); 
						$last = substr($str,$end,strlen($str));
						$first = substr($str,$start,$end);
					
						$final = '<span class="bold">'.$first.'</span>'.$last;
						$result.='<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
					}
					$result.="</ul>";
				}
				else
				{
					$result=0;
				}
				return $result;
		}//end function search
}//end ClassManager	

//"SELECT * FROM userlog WHERE First_Name LIKE '$data%' OR Last_Name
	//					LIKE '$data%' OR Email LIKE '$data%' limit 0,20"
	
?>