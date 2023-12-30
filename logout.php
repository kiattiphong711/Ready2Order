<?php
ob_start(); // for header
session_start(); // open session start function

// remove session from Login
unset($_SESSION['mycustomer_id']); // remove mycustomer_id sesion
unset($_SESSION['mycustomer_status']); // remove mycustomer_status sesion

// remove session from Basket
unset($_SESSION['sess_id']); // remove sess_id sesion
unset($_SESSION['sess_name']); // remove sess_name sesion
unset($_SESSION['sess_price']); // remove sess_price sesion
unset($_SESSION['sess_num']); // remove sess_num sesion
unset($_SESSION['sess_special']); // remove sess_special special


// remove all sesion
// session_destroy();

// redirect to login.php
header('Location:login.php');
