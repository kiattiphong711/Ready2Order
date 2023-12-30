<?php
// ออเดอร์เข้าล่าสุด
function str_time_diff($timestamp = null, $html = true, $days_before_full_date = 3)
{
    // เราจะหาค่า "ช่วงห่างของเวลาปัจจุบันกับเวลาที่กำหนด"
    // โดยเวลาปัจจุบันนั้นหาได้จากฟังก์ชั่น time()
    // ซึ่งเวลาที่กำหนดนั้นก็จะอยู่ในตัวแปร $timestamp
    // ซึ่งทั้งหมดจะมีหน่วยเป็นวินาที ซึ่งจะเก็บไว้ในตัวแปร $diff
    // แต่ก่อนอื่นเราต้องตรวจว่า $timestamp เป็นตัวเลขหรือไม่
    if (is_numeric($timestamp)) {
        // ถ้าใช่ ก็เอาไปลบกับเวลาปัจจุบันเลย
        $diff = time() - $timestamp;
    } else {
        // ถ้าไม่ ก็อนุมานว่ามันเป็นสตริง เช่น 2013-03-07 07:57:12
        // ลองเอาไปแปลงเป็นวินาทีด้วย strtotime() แล้วลบกับเวลาปัจจุบัน
        $diff = time() - strtotime($timestamp);
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp เป็น 0
    if (!$diff) {
        $str = "เมื่อกี้นี้เอง";
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 นาที
    elseif ($diff < 60) {
        $str = "เมื่อ $diff วินาทีที่แล้ว";
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 ชั่วโมง
    elseif ($diff < 3600) {
        $str = 'เมื่อ ' . (int)($diff / 60) . ' นาทีที่แล้ว';
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่า 1 วัน
    elseif ($diff < 86400) {
        $str = 'เมื่อ ' . (int)($diff / 3600) . ' ชั่วโมงที่แล้ว';
    }
    // หากความต่างของเวลาปัจจุบันกับ $timestamp น้อยกว่าจำนวนวันที่กำหนดไว้
    // ในตัวแปร $days_before_full_date ที่เราจะใช้เป็นตัวบอกว่า
    // ควรจะแสดงวันที่เต็มเมื่อช่วงห่างเกินกี่วัน
    elseif ($diff < 86400 * $days_before_full_date) {
        $str = 'เมื่อ ' . (int)($diff / 86400) . ' วันที่แล้ว';
    }
    // หากตัวแปร $html เป็นจริง
    // หรือตัวแปร $str ยังไม่ถูกสร้างขึ้น ซึ่งเป็นเพราะช่วงห่างไม่อยู่ในเงื่อนไขข้างต้นเลย
    if ($html || !isset($str)) {
        // ตัวแปรที่ใช้แสดงผลชื่อเดือนภาษาไทย
        static $months = array(
            // ให้ index เริ่มที่ 1
            1 => 'มกราคม',  'กุมภาพันธ์', 'มีนาคม',    'เมษายน',
            'พฤษภาคม', 'มิถุนายน',  'กรกฎาคม',  'สิงหาคม',
            'กันยายน',  'ตุลาคม',   'พฤศจิกายน', 'ธันวาคม'
        );
        // หาค่าส่วนต่างๆ ของวันที่ปัจจุบันที่ต้องการ ด้วย explode() สตริงที่สร้างจาก date()
        // สมมติ date('j n Y H:s') สร้างสตริงออกมาแบบนี้ '8 4 2013 04:29'
        // เมื่อ explode() สตริงดังกล่าวโดยมี "ช่องว่าง" เป็นตัวแบ่ง
        // ก็จะได้ array('8', '4', '2013', '04:29')
        // และเพราะ array ดังกล่าวเป็น indexed array
        // เราจึงสามารถแยกใส่ตัวแปรได้ด้วย list()
        list($day, $month, $year, $time) = explode(' ', date('j n Y H:s'));
        // ทำค.ศ.ให้เป็นพ.ศ.ด้วยการ +543
        $year += 543;
        // วันที่เต็ม ที่จะใช้แสดงแบบเต็ม หรือใช้ใน attribute title
        $full_str = "เมื่อวันที่ $day $months[$month] $year เวลา $time น.";
        // หาก $str ยังไม่ได้ถูกสร้างขึ้น แสดงว่าเราต้องแสดงวันที่แบบเต็ม
        if (!isset($str)) {
            // ทำให้ $str มีค่าเดียวกันกับ $full_str
            $str = $full_str;
        }
    }
    // คืนค่ากลับไป
    return $str;
}
// function วันที่แบบภาษาไทย
function DateThaiFull($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute น.";
}

// function วันที่แบบตะวันตก
function DateInterFull($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strDay/$strMonth/$strYear $strHour:$strMinute:$strSeconds";
}

/* ตัวอย่าง หัวข้อคอนเทน
ภาพรวม          หน้าหลัก/ภาพรวม/จัดการภาพรวม 
ด้วยการใช้ funciton topicName , topicName2, topicSecond ตามลำดับ
*/

function topicName($files)
{
    switch ($files) {
        case '':
            $file = 'ภาพรวม';
            break;
        case 'dashboard':
            $file = 'ภาพรวม';
            break;
        case 'category':
            $file = 'ประเภทอาหาร';
            break;
        case 'food':
            $file = 'เมนูอาหาร';
            break;
        case 'system':
            $file = 'ผู้ดูแลระบบ';
            break;
        case 'customer':
            $file = 'ผู้ใช้งาน';
            break;
        case 'order':
            $file = 'ออเดอร์';
            break;
        case 'report':
            $file = 'รายงาน';
            break;
    }
    return $file;
}

function topicName2($files2)
{
    $mn = $files2; // ชื่อไฟล์เริ่มต้น เช่น index.php?mn=dashboard&file=dash_list ค่าที่ได้คือ mn=dashboard
    $mn2 = $files2 . '_list'; // ไฟล์เริ่มต้นในโฟลเดอร์แรก เช่น admin_dashboard ไฟล์เริ่มต้น dah_list.php
    switch ($files2) {
        case '':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=dashboard&file=dashboard_list\">ภาพรวม</a></li>";
            break;
        case 'dashboard':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">ภาพรวม</a></li>";
            break;

        case 'category':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">ประเภทอาหาร</a></li>";
            break;
        case 'food':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">เมนูอาหาร</a></li>";
            break;
        case 'system':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">ผู้ดูแลระบบ</a></li>";
            break;
        case 'customer':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">ผู้ใช้งาน</a></li>";
            break;
        case 'order':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">ออเดอร์</a></li>";
            break;
        case 'report':
            $mn = "  <li class=\"breadcrumb-item\"><a href=\"?mn=$mn&file=$mn2\">รายงาน</a></li>";
            break;
    }
    return $mn;
}

function topicSecond($topiclast)
{
    $file = $topiclast;
    switch ($file) {
        case '':
            $file = "<li class=\"breadcrumb-item active\">ภาพรวมทั้งหมด</li>";;
            break;
        case 'dashboard_list':
            $file = "<li class=\"breadcrumb-item active\">ภาพรวมทั้งหมด</li>";;
            break;

        case 'category_list':
            $file = "<li class=\"breadcrumb-item active\">รายการประเภทอาหาร</li>";;
            break;
        case 'category_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มประเภทอาหาร</li>";;
            break;
        case 'category_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดประเภทอาหาร</li>";;
            break;
        case 'category_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขประเภทอาหาร</li>";;
            break;
        case 'category_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบประเภทอาหาร</li>";;
            break;

        case 'food_list':
            $file = "<li class=\"breadcrumb-item active\">รายการเมนูอาหาร</li>";;
            break;
        case 'food_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มเมนูอาหาร</li>";;
            break;
        case 'food_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขเมนูอาหาร</li>";;
            break;
        case 'food_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดเมนูอาหาร</li>";;
            break;
        case 'food_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบเมนูอาหาร</li>";;
            break;

        case 'system_list':
            $file = "<li class=\"breadcrumb-item active\">รายการผู้ดูแลระบบ</li>";;
            break;
        case 'system_add':
            $file = "<li class=\"breadcrumb-item active\">เพิ่มผู้ดูแลระบบ</li>";;
            break;
        case 'system_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขผู้ดูแลระบบ</li>";;
            break;
        case 'system_change':
            $file = "<li class=\"breadcrumb-item active\">เปลี่ยนรหัสผ่าน</li>";;
            break;
        case 'system_delete':
            $file = "<li class=\"breadcrumb-item active\">ลบผู้ดูแลระบบ</li>";;
            break;

        case 'customer_list':
            $file = "<li class=\"breadcrumb-item active\">รายการผู้ใช้งาน</li>";;
            break;
        case 'customer_edit':
            $file = "<li class=\"breadcrumb-item active\">แก้ไขผู้ใช้งาน</li>";;
            break;
        case 'customer_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดผู้ใช้งาน</li>";;
            break;

        case 'order_waiting':
            $file = "<li class=\"breadcrumb-item active\">รายการรอการยืนยันออเดอร์</li>";;
            break;
        case 'order_confirm':
            $file = "<li class=\"breadcrumb-item active\">รายการรับออเดอร์</li>";;
            break;
        case 'order_working':
            $file = "<li class=\"breadcrumb-item active\">รายการกำลังทำอาหาร</li>";;
            break;
        case 'order_finish':
            $file = "<li class=\"breadcrumb-item active\">รายการอาหารของคุณเสร็จแล้ว</li>";;
            break;
        case 'order_cancel':
            $file = "<li class=\"breadcrumb-item active\">รายการยกเลิกออเดอร์แล้ว</li>";;
            break;
        case 'order_list':
            $file = "<li class=\"breadcrumb-item active\">รายการออเดอร์ทั้งหมด</li>";;
            break;
        case 'order_detail':
            $file = "<li class=\"breadcrumb-item active\">รายละเอียดออเดอร์</li>";;
            break;

        case 'report_list':
            $file = "<li class=\"breadcrumb-item active\">รายงานออเดอร์รายวัน</li>";;
            break;
        case 'report_month':
            $file = "<li class=\"breadcrumb-item active\">รายงานออเดอร์รายเดือน</li>";;
            break;
        case 'report_year':
            $file = "<li class=\"breadcrumb-item active\">รายงานออเดอร์รายปี</li>";;
            break;
        case 'report_best_day':
            $file = "<li class=\"breadcrumb-item active\">รายการขายดีประจำวัน</li>";;
            break;
        case 'report_best_month':
            $file = "<li class=\"breadcrumb-item active\">รายการขายดีประจำเดือน</li>";;
            break;
    }
    return $file;
}
