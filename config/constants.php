<?php
ob_start();
session_start();
error_reporting(E_ALL ^ E_NOTICE); // ปิด warning php ตัวแปรที่ประกาศลอยๆ
//Start Session

// Localhost
// define('SITEURL', 'http://localhost/project/');
// define('LOCALHOST', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'ready2order');
 
define('SITEURL', 'http://www.ready2orderproject.com/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'ready2ord1_ohmza25');
define('DB_PASSWORD', 'Ohmza2425');
define('DB_NAME', 'ready2ord1_ready2order');

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
mysqli_query($conn, 'set NAMES utf8');
mysqli_query($conn, 'SET character_set_results=utf8');
mysqli_query($conn, 'SET character_set_client=utf8');
mysqli_query($conn, 'SET character_set_connection=utf8');
date_default_timezone_set('Asia/Bangkok');
