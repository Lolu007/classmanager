<?php

namespace classmanager\core\managers;

use classmanager\core\db\persistence\Persistence;
use PDO;

class ClassManager
{
    private $db;

    /** @var PDO $pdo */
    private $pdo;

    /**
     * ClassManager constructor.
     * @param Persistence $db
     */
    public function __construct(Persistence $db)
    {
        $this->db = $db;

        $this->pdo = $db->getPdo();
    }

    public function treatRequest()
    {
        $typeOfRequest = $_GET['type'];

        switch ($typeOfRequest) {
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
    }

    public function addResults(): void
    {
        $matric = $_GET['matric'];
        $cgpa = $_GET['cgpa'];

        $sql = "INSERT INTO results VALUES('$matric','$cgpa','" . time() . "')";

        $this->db->executeQuery($sql);
    }

    function checkMatric($matric)
    {
        $res = $this->db->countRows("SELECT * FROM classmembers WHERE matricNo='$matric'");
        if ($res == 0) {
            return false;
        } else {
            return true;
        }

    }

    public function getStudent($matricNumber)
    {
        $std = $this->pdo->query("SELECT * FROM classmembers WHERE matricNo = ' $matricNumber ' ");

        return $std->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMembers()
    {
        $std = $this->pdo->query("SELECT * FROM classmembers");

        return $std->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editStud()
    {

        $matric = $_GET['matric'];
        $fname = $_GET['fname'];
        $mname = $_GET['mname'];
        $lname = $_GET['lname'];
        $dob = $_GET['mon'] . " " . $_GET['days'];
        $sex = $_GET['gender'];
        $hall = $_GET['hall'];
        $roomno = $_GET['roomno'];
        $phone = $_GET['phone'];
        $email = $_GET['email'];
        $address = addslashes($_GET['address']);
        $kinname = $_GET['kinname'];
        $kinphone = $_GET['kinphone'];

        //$dob = strtotime("$mon $day");
        $report = "";
        //to validate email
        $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
        if (empty($matric)) {
            $report .= "Matric field is empty!<br>";
        }
        if (!empty($matric) && (strlen($matric) < 6 || strlen($matric) > 6)) {
            $report .= "You have entered an invalid Matric Number<br>";
        }

        if (!empty($report)) {
            throw new \RuntimeException('Unable to edit student');
        } else {

            $studDet = $this->getStudent($matric);

            $query = "UPDATE classmembers SET ";
            $query .= " matricNo='$matric'";

            if (!empty($fname) && strcmp($fname, $studDet['fname']) != 0) {
                $query .= ", fname='$fname'";
                $m .= "First Name<br>";
            }
            if (!empty($mname) && strcmp($mname, $studDet['mname']) != 0) {
                $query .= ", mname='$mname'";
                $m .= "Middle Name<br>";
            }
            if (!empty($lname) && strcmp($lname, $studDet['lname']) != 0) {
                $query .= ", lname='$lname'";
                $m .= "Last Name<br>";
            }
            if (!empty($phone) && strcmp($phone, $studDet['phone']) != 0) {
                $query .= ", phone='$phone'";
                $m .= "Phone Number<br>";
            }
            if (!empty($email) && strcmp($email, $studDet['email']) != 0) {
                $query .= ", email='$email'";
                $m .= "Email Address<br>";
            }
            if (!empty($dob) && strcmp($dob, $studDet['dob']) != 0) {
                $query .= ", dob='$dob'";
                $m .= "Birthday<br>";
            }
            if (!empty($sex) && strcmp($sex, $studDet['sex']) != 0) {
                $query .= ", sex='$sex'";
                $m .= "Sex<br>";
            }
            if (!empty($hall) && strcmp($hall, $studDet['hallofres']) != 0) {
                $query .= ", hallofres='$hall'";
                $m .= "Hall of residence<br>";
            }
            if (!empty($roomno) && strcmp($roomno, $studDet['roomno']) != 0) {
                $query .= ", roomno='$roomno'";
                $m .= "Room Number<br>";
            }
            if (!empty($address) && strcmp($address, $studDet['address']) != 0) {
                $query .= ", address='$address'";
                $m .= "Home Address<br>";
            }
            if (!empty($kinname) && strcmp($kinname, $studDet['nextofkin_name']) != 0) {
                $query .= ", nextofkin_name='$kinname'";
                $m .= "Next of Kin's name<br>";
            }
            if (!empty($kinphone) && strcmp($kinphone, $studDet['nextofkin_phone']) != 0) {
                $query .= ", nextofkin_phone='$kinphone'";
                $m .= "Next of Kin's phone number<br>";
            }

            $query .= " where matricNo='$matric'";

            $this->pdo->exec($query);
        }
    }

    public function registerMember()
    {
        $matric = $_GET['matric'];
        $fname = $_GET['fname'];
        $mname = $_GET['mname'];
        $lname = $_GET['lname'];
        $dob = $_GET['mon'] . " " . $_GET['days'];
        $sex = $_GET['sex'];
        $hall = $_GET['hall'];
        $roomno = $_GET['roomno'];
        $phone = $_GET['phone'];
        $email = $_GET['email'];
        $address = addslashes($_GET['address']);
        $kinname = $_GET['kinname'];
        $kinphone = $_GET['kinphone'];

        $report = "";
        //to validate email
        $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
        if (empty($matric)) {
            $report .= "Matric field is empty!<br>";
        }
        if (!empty($matric) && (strlen($matric) < 6 || strlen($matric) > 6)) {
            $report .= "You have entered an invalid Matric Number<br>";
        }

        //if this return false then no such matric add the guy
        if (!$this->checkMatric($matric)) {
            $sql = sprintf("INSERT INTO classmembers (id,matricNo,fname,mname,lname,sex,address,hallofres,roomno,email,phone,dob,nextofkin_name,nextofkin_phone,dateadded) VALUES ('','$matric','$fname','$mname','$lname','$sex','$address','$hall','$roomno','$email','$phone','$dob','$kinname','$kinphone','" . time() . "')");

            if ($this->db->executeQuery($sql)) {
                return $this->admin->setSuccess("<br>Matric number <strong>$matric</strong> added successfully!<br>"); //1;insertion was successful
            } else {
                return 0;
            }
        }
    }

    public function insertHall($hallname)
    {
        /*if(empty($hallname))
        {
            return "You did not enter any hall";
        }*/
        $cd = new UniqueCode("hallofres", "hallcode");
        $hallcode = $cd->getCode();

        $sql = sprintf("INSERT INTO hallofres (hallcode, hall, datecreated, lastupdate) VALUES ('%s','%s','%s','%s')", $hallcode, $hallname, time(), time());

        if ($this->db->executeQuery($sql))
            return 1; // insertion was successful
        else
            return 0;    //insertion was not successful.
    }

    public function insertCourse($courselevel, $course, $coursecode)
    {

        $sql = sprintf("INSERT INTO courses (coursecode, courselevel, coursetitle, datecreated, lastupdate) VALUES ('%s','%s','%s','%s','%s')", $coursecode, $courselevel, $course, time(), time());

        if ($this->db->executeQuery($sql))
            return 1; // insertion was successful
        else
            return 0;    //insertion was not successful.
    }

    public function editMaterial()
    {
        $mat_id = $_POST['mat_id'];
        $course = $_POST['course'];
        $pages = $_POST['pages'];
        $price = $_POST['price'];//price per page


        if (empty($pages) || empty($price)) {
            throw new \RuntimeException('An error occurred');
        } else {
            $total = $pages * $price;

            $rs = $this->db->executeQuery("SELECT * FROM materials_sale WHERE material_id='$mat_id'");

            $query = "UPDATE materials_sale SET ";

            $query .= " material_id='" . $rs['material_id'] . "'";

            $m = '';
            if (!empty($pages) && strcmp($pages, $rs['pages']) != 0) {
                $query .= ", pages='$pages'";
                $m .= "Number of pages<br>";
            }
            if (!empty($price) && strcmp($price, $rs['price_page']) != 0) {
                $query .= ", price_page='$price'";
                $m .= "Price per page<br>";
            }
            if (!empty($total) && strcmp($total, $rs['total']) != 0) {
                $query .= ", total='$total'";
                $m .= "Total cost of the material<br>";
            }

            $query .= " WHERE material_id='" . $rs['material_id'] . "'";

            $this->db->executeQuery($query);
        }

    }

    public function createMaterial()
    {
        $course = $_POST['course'];
        $pages = $_POST['pages'];
        $price = $_POST['price'];//price per page

        $total = $pages * $price;

        $id = time() . substr(md5($course . time()), 0, 17);

        $sql = sprintf("INSERT INTO materials_sale (id, material_id, course, pages, price_page, total,total_booked, datecreated) VALUES ('', '$id','$course','$pages','$price','$total','','" . time() . "')");

        if ($this->db->executeQuery($sql))
            return "You have successfully created a material";
        else
            return 0;
    }

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

        if (empty($balpaid)) {
            return $this->admin->setError("You are not making any balance payment!<br>Please enter balance");
        }
        if ($inibal > $balpaid) {
            $balance = $inibal - $balpaid;
            $change = 0;
            $fullpay = $matCost;
        } else if ($inibal < $balpaid && $inibal != 0) {
            $change = $balpaid - $inibal;
            $balance = 0;
            $fullpay = $matCost;

        } else {
            $balance = 0;
            $change = 0;
            $fullpay = $matCost;
        }

        $qry = "UPDATE payments SET s_change='$change', balance='$balance', amount_paid='$fullpay' WHERE student_matric='$matric' AND material_Id='$material_Id'";

        $this->db->executeQuery($qry);

        if ($this->db->executeQuery($qry))
            return "Successful";
        else
            return 0;
    }

    public function payForMaterial()
    {
        $material_Id = $_GET['mat_id'];
        $matric = $_GET['keyword'];
        $amount = $_GET['amountpaid'];
        $materialCost = $_GET['totalcost'];
        //$change = $_GET['change'];
        $amt = $amount;
        if (empty($amount)) {
            $amount = 0;//$err.="You did not enter amount paid<br>";
        }
        if ($materialCost > $amount) {
            $balance = $materialCost - $amount;
            $change = 0;
        } else if ($materialCost < $amount) {
            $change = $amount - $materialCost;
            $balance = 0;
        } else {
            $balance = 0;
            $change = 0;
        }

        $err = "";

        if (empty($matric)) {
            $err .= "You did not enter student making payment<br>";
        }

        if (!empty($err)) {
            throw new \RuntimeException($err);
        } else {
            $qry = "SELECT * FROM payments WHERE student_matric='$matric' AND material_Id='$material_Id'";

            if ($this->db->countRows($qry) > 0) {
                return "Payment has been made for this material by Matric {$matric}";
            } else {
                $sql = sprintf("INSERT INTO payments (id, student_matric, material_Id, amount_paid, balance, s_change, datepaid, collected) VALUES ('','$matric','$material_Id','$amount','$balance','$change','" . time() . "','0')");

                $qry = "UPDATE materials_sale SET total_booked = total_booked + '1' WHERE material_id= '$material_Id'";
                $this->db->executeQuery($qry);

                if ($this->db->executeQuery($sql)) {
                    if (empty($amt)) {
                        return "You have successfully booked for <strong>$matric</strong> no payment yet";
                    } else
                        return "You have successfully paid for <strong>$matric</strong>";
                } else
                    return 0;
            }
        }
    }

    public function searchStudent()
    {
        $keyword = $_POST['data'];
        $query = "SELECT * FROM classmembers WHERE fname LIKE '$keyword%' OR lname LIKE '$keyword%' OR matricNo LIKE '$keyword%' limit 0,20";

        $res = $this->pdo->query($query);

        if ($this->db->countRows($query) > 0) {
            $result = '<ul class="list">';

            foreach($res->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $str = $row['matricNo'];
                $start = strpos($str, $keyword);
                $end = similar_text($str, $keyword);
                $last = substr($str, $end, strlen($str));
                $first = substr($str, $start, $end);

                $final = '<span class="bold">' . $first . '</span>' . $last;
                $result .= '<li><a href=\'javascript:void(0);\'>' . $final . '</a></li>';
            }
            $result .= "</ul>";
        } else {
            $result = 0;
        }
        return $result;
    }

    public function searchMembersBirthday($month)
    {
        $res = $this->pdo->query("SELECT * FROM classmembers WHERE dob LIKE '$month%' order by lname desc");

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}