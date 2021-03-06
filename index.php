<?php

require_once('bootstrap.php');

$auth = new \classmanager\core\auth\Authenticator($dbo);

if (isset($_POST['login'])) {
    $info = $auth->login($_POST['username'], $_POST['password']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>::CLASS MANAGER v1.0::LOGIN</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<center>
    <div id="container">
        <div id="header"></div>
        <div id="contentWrapper">
            <div id="content">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="80%" valign="top">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <center>
                                            <table width="60%">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="263">
                                                        <form id="form1" name="form1" method="post" action="">
                                                            <table width="100%" border="0" cellpadding="4"
                                                                   cellspacing="4" id="loginbg" height="300">
                                                                <tr>
                                                                    <td width="33%">&nbsp;</td>
                                                                    <td width="67%">&nbsp;</td>
                                                                </tr>
                                                                <?php if (isset($info)) { ?>
                                                                    <tr>

                                                                        <td align="center" colspan="2">
                                                                            <div id="info"><?php echo $info; ?></div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                    <td height="27">&nbsp;</td>
                                                                    <td align="left">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="33%" align="right" valign="middle"
                                                                        class="tblabel">Username:
                                                                    </td>
                                                                    <td width="67%"><input name="username" type="text"
                                                                                           id="username" required/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="33%" align="right" valign="middle"
                                                                        class="tblabel">Password:
                                                                    </td>
                                                                    <td width="67%"><input name="password"
                                                                                           type="password"
                                                                                           id="password" required/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="33%">&nbsp;</td>
                                                                    <td width="67%"><input type="submit"
                                                                                           name="login"
                                                                                           id="login"
                                                                                           value="Login"/>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td height="30">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </center>
                                    </td>

                                </tr>
                            </table>
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
