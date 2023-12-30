<?php
ob_start();
session_start();
// remove session from variables
unset($_SESSION['user_admin']);
unset($_SESSION['status_login']);
// remove all sesion
// session_destroy();
header('Location:login.php');
