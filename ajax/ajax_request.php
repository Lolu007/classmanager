<?php

use classmanager\core\managers\ClassManager;

require_once('../bootstrap.php');

$class = new ClassManager($dbo);

echo $class->treatRequest();