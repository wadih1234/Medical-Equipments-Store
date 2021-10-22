<?php
session_start();
session_destroy();
header("Location:../manager/managers_login/managerLogin.php");
?>