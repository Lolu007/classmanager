<?php
require_once('bootstrap.php');
require_once('auth_check.php');

$user = '';
$adminstatus = '';
$name = '';

$members = $classManager->getMembers();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>::CLASS MANAGER v1.0::Managing birthdays</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>

    <script language="javascript" src="javascript/functions.js"></script>
    <script language="javascript" src="javascript/util.js"></script>

    <script language="javascript" src="Suggest/js/jquery.js"></script>
    <script language="javascript" src="Suggest/js/script.js"></script>
    <link href="Suggest/css/style.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        <!--
        .style8 {
            color: #FF0000
        }

        -->
    </style>
</head>

<body>
<center>
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
                                                <tr>
                                                    <td colspan="2" align="center">Search for birthday<br/><br/></td>
                                                </tr>
                                                <tr>
                                                    <td width="33%" valign="top" align="left" class="tblabel">Enter Name
                                                        or Matric number
                                                    </td>
                                                    <td width="67%" valign="top">
                                                        <div class="main">
                                                            <div id="holder">
                                                                <input type="text" name="keyword" tabindex="0"
                                                                       id="keyword"
                                                                       value=""
                                                                       onkeyup="searchBirthdays();"/>
                                                                <br/>
                                                                <img src="images/load.gif" name="loading" id="loadin"/>
                                                            </div>
                                                            <div id="ajax_response"></div>
                                                        </div>
                                                        <br/>
                                                        <input type="button" id="go" name="go" value="Search"
                                                               onclick="searchBirthdays();"/></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <!---->
                                    <tr>
                                        <td height="148">
                                            <hr/>
                                            <table>
                                                <tr>
                                                    <td colspan="6">Search by month: <select name="month" id="month"
                                                                                             onchange="loadBirthdays();">
                                                            <option value="">-select-</option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select><br/><br/></td>
                                                </tr>
                                            </table>

                                            <div id="betday">
                                                <table width="100%">

                                                    <tr align="center" valign="middle" class="tableheader">
                                                        <td><span class="style9">S/N</span></td>
                                                        <td><span class="style9">NAME</span></td>
                                                        <td><span class="style9">DATE OF BIRTH</span></td>
                                                        <td><span class="style9">EMAIL</span></td>
                                                        <td><span class="style9">PHONE</span></td>
                                                        <td><span class="style9">HALL/RMN</span></td>

                                                    </tr>

                                                    <?php
                                                    $i = 0;
                                                    foreach ($members as $member) {
                                                        if ($i % 2 == 0) {
                                                            $class = "t1";
                                                            $i++;
                                                        } else {
                                                            $class = "t2";
                                                            $i++;
                                                        }
                                                        ?>
                                                        <tr class="<?php echo $class; ?>">
                                                            <td align="center" valign="top"><?php echo $i; ?></td>

                                                            <td align="center" valign="middle"><span
                                                                        class="style5"><?php echo $member['fname'] . " " . $member['lname']; ?></span>
                                                            </td>
                                                            <td align="left" valign="middle"><span
                                                                        class="style6"><?php echo $member['dob']; ?></span>
                                                            </td>
                                                            <td align="left" valign="middle"><span
                                                                        class="style6"><?php echo $member['email']; ?></span>
                                                            </td>
                                                            <td align="left" valign="middle"><span
                                                                        class="style7"><?php echo $member['phone']; ?></span>
                                                            </td>
                                                            <td align="left" valign="middle"><span
                                                                        class="style7"><?php echo $member['roomno']; ?></span>
                                                            </td>

                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
                <div id="footer"><?php include("footer.php"); ?></div>
            </div>
        </div>
    </div>
</center>
</body>
</html>
