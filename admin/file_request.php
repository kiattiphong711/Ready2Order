<?php
//----------------- GET File form module-----------------------------------
// นำเข้า folder ตัวแปร mn แทนชื่อ admin_folder(ชื่อfolder) ตัวแปร file แทนชื่อไฟล์
$file = 'admin_' . $_GET['mn'] . '/' . $_GET['file'] . '.php';
if (file_exists($file) && isset($_GET['mn']) && isset($_GET['file'])) {
    // นำเข้าไฟล์จากตัวแปลที่รับด้านบน
    require $file;
} elseif (file_exists($file) or !$_GET['mn'] or !$_GET['file']) {
    // หน้าเริ่มต้นเมือทำการ login เข้าสู่ระบบ
    require 'admin_dashboard/dashboard_list.php';
} else {
    // กรุณาใส่ลิงค์ url ผิดพลาดจะเรียกหน้า 404 ขึ้นมาเพื่อแจ้งเตือน
    require '404.html';
}
// แสดง Error debug file.
error_reporting(E_ALL); // เพราะตรงนี้
ini_set("display_errors", 1); // และตรงนี้ทำงานแล้ว
