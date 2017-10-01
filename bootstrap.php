<?php

use classmanager\core\db\persistence\MysqlPersistence;
use classmanager\core\managers\ClassManager;

session_start();

require_once(__DIR__ . '/vendor/autoload.php');

$dbo = new MysqlPersistence();

$adminRepository = new \classmanager\core\db\repositories\AdminRepository($dbo);

$admin = new \classmanager\core\managers\AdminManager($adminRepository);

$classManager = new ClassManager($dbo);