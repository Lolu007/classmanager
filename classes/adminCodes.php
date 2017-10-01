<?php

/**
 * Class AdminManager
 */
class AdminManager2
{
    private $auth;

    public function __construct()
    {
        $this->auth = new \classmanager\core\auth\Authenticator();
    }

    public function adminDetails()
    {
        $rs = $this->db->fetchData("SELECT * FROM admin WHERE adminId='" . $_SESSION['adminId'] . "'");
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

        $errormsg = "";
        //to validate email
        $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

        if ($username == "") {
            $errormsg .= "Username is empty<br>";
        }
        if (!empty($username) && strlen($username) < 6) {
            $errormsg .= "Username is too short!<br>";
        }

        if ($password == "") {
            $errormsg .= "Password is empty<br>";
        }
        if (!empty($password) && strlen($password) < 6) {
            $errormsg .= "Password is too short!<br>";
        }
        if ($password != $password2) {
            $errormsg .= "Passwords does not match<br>";
        }

        if ($name == "") {
            $errormsg .= "Name field is empty<br>";
        }

        if (empty($email) || (!preg_match($regexp, $email))) {
            $errormsg .= "Invalid email address.<br>";
        }

        if (strlen($phone) != 11 || !preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone)) {
            $errormsg .= "The telephone number you entered is invalid.<br>";
        }

        if (!empty($errormsg)) {
            return $report = $this->setError($errormsg);

        } else//1
        {
            $adminDet = AdminManager::adminDetails();
            if (!$this->validateAdmin($username, $password))//if this return false then no such user add the guy
            {

                $query = "UPDATE admin SET ";
                $query .= " adminId='" . $_SESSION['adminId'] . "'";
                if (!empty($username) && strcmp($username, $adminDet['username']) != 0) {
                    $query .= ", username='$username'";
                    $m .= "Username<br>";
                }

                if (!empty($password) && strcmp($password, $adminDet['password']) != 0 && strcmp($password, $password2) == 0) {
                    $query .= ", password='" . md5($password) . "'";
                    $m .= "Password<br>";
                }
                if (!empty($name) && strcmp($name, $adminDet['name']) != 0) {
                    $query .= ", name='$name'";
                    $m .= "Name<br>";
                }

                if (!empty($phone) && strcmp($phone, $adminDet['phone']) != 0) {
                    $query .= ", phone='$phone'";
                    $m .= "Phone Number<br>";
                }
                if (!empty($email) && strcmp($email, $adminDet['email']) != 0) {
                    $query .= ", email='$email'";
                    $m .= "Email Address<br>";
                }

                $query .= " where adminId='" . $_SESSION['adminId'] . "'";
                //echo $query;
                mysql_query($query) or die(mysql_error());
                if (!empty($m)) {
                    //session_destroy();
                    session_start();
                    error_reporting(E_ALL ^ E_NOTICE);

                    return $this->setSuccess("<b>The following data was successfully changed</b> <br>" . $m);
                } else {
                    return $this->setSuccess("You did not edit any of your information ");
                }
            }//end if
            else {
                return $this->setError("Username already exist!");
            }
        }//else1
    }

    public function newAdmin()
    {
        $username = $_POST['adminuser'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $status = $_POST['admintype'];

        $errormsg = "";
        //to validate email
        $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

        if ($username == "") {
            $errormsg .= "Username is empty<br>";
        }
        if (!empty($username) && strlen($username) < 6) {
            $errormsg .= "Username is too short!<br>";
        }

        if ($password == "") {
            $errormsg .= "Password is empty<br>";
        }
        if (!empty($password) && strlen($password) < 6) {
            $errormsg .= "Password is too short!<br>";
        }
        if ($password != $password2) {
            $errormsg .= "Passwords does not match<br>";
        }

        if ($name == "") {
            $errormsg .= "Name field is empty<br>";
        }

        if (empty($email) || (!preg_match($regexp, $email))) {
            $errormsg .= "Invalid email address.<br>";
        }

        if (strlen($phone) != 11 || !preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone)) {
            $errormsg .= "The telephone number you entered is invalid.<br>";
        }

        if (!empty($errormsg)) {
            return $report = $this->setError($errormsg);
        } else {
            //if this return false then no such user add the guy
            if (!$this->validateAdmin($username, $password)) {
                $createdById = $_SESSION['adminId'];//setting the user creating new user
                $adminid = time() . substr(md5($email), 0, 17);

                $sql = sprintf("INSERT INTO admin (id,adminId,username,password,name,email,phone,createdBy,status,datecreated) VALUES ('','$adminid','$username','" . md5($password) . "','$name','$email','$phone','$createdById','$status','" . time() . "')");

                if ($this->db->executeQuery($sql)) {
                    return $this->setSuccess("<br>New user added successfully!<br>"); //1;insertion was successful
                } else {
                    return 0;        //insertion was not successful
                }
            } else//3 else it returns true, the user exist...
            {
                return $this->setError("Username already exist!");
            }//end else3

        }
    }

    public function adminLogout()
    {
        //unset the variables
        //session_destroy();
        unset($_SESSION['adminId']);
        unset($_SESSION['logged']);
        //session_start();
        error_reporting(E_ALL ^ E_NOTICE);
        header("location:index.php?out=" . base64_encode("You have logged out successfully!") . $_SESSION['adminId']);
    }

    private function validateAdmin($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE username='$username' AND password='" . md5($password) . "'";

        $res = $this->db->getNumOfRows($sql);
        if ($res == 0) {
            return false;

        } else {
            return true;
        }

    }

    public function setError($errormsg)
    {
        return "<div id='errorbox'><table width='100%' cellpadding='0' cellspacing='0'>" .
            "<tr bgcolor='white'><td width='32'><img src='images/icons/error.png'></td><td><font color='red'><strong>Sorry, the following error(s) occured</strong></font></td></tr>" .
            "<tr><td colspan='2'><font color='white' size='-1'>" . $errormsg . "</font></td></tr></table></div>";
    }

    public function setSuccess($successmsg)
    {
        return "<div id='sucbox'><table width='100%' cellpadding='0' cellspacing='0' align='center'>" . "<tr bgcolor='#3399FF'><td  width='32'><img src='images/icons/info.png'></td><td><font color='white'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Successfull!</strong></font></td></tr>" .
            "<tr><td colspan='2'><div class='success'>" . $successmsg . "</div></td></tr></table></div>";
    }
}
