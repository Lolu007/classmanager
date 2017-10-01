<?php
require_once('bootstrap.php');

$auth = new \classmanager\core\auth\Authenticator($dbo);

$auth->logout();