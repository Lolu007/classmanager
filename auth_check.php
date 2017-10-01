<?php

if (!isset($_SESSION['adminId']) && ($_SESSION['logged'] !== true)) {
    header("location:index.php?error=" . base64_encode("Unauthorized Access, please login"));
}