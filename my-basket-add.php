<?php
include('config/constants.php');
// ถ้าไม่มีการ login ไม่สามารถเข้าสู่หน้านี้ได้
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit; // ออกการทำงานเมื่อใ้ช้ function exit
}


$id_prd = $_GET['id_prd']; // foods ค่า id


$_SESSION['sess_id']; // สร้าง session_id เก็บ foods id ในรูปแบบ Array session
$_SESSION['sess_name']; // สร้าง sess_name เก็บ foods name ในรูปแบบ Array session
$_SESSION['sess_price']; // สร้าง sess_price เก็บ foods price ในรูปแบบ Array session
$_SESSION['sess_num']; // สร้าง sess_num เก็บ foods จำนวนที่สั่ง ในรูปแบบ Array session

// foods id กำหนดจำนวนอาหารที่เลือกให้เท่ากับ 1 อัน เป็นค่าเริ่มต้น
// โดยตรวจสอบ session ว่า sess_id ซ้ำกันหรือไม่ ถ้าไม่ซ้ำกำหนดให้เท่ากับ 1
if (!in_array($id_prd, $_SESSION['sess_id'])) {
    $check = 1;
} else {
    // กรณี foods id มีการเลือกใส่รถเข็นตั้งแต่ 1 ขึ้นไป ให้ทำการบวกเพิ่ม
    for ($i = 0; $i < count($_SESSION['sess_id']); $i++) {
        if ($_SESSION['sess_id'][$i] == $id_prd) {
            // SELECT foods จากค่า method get id_prd
            $sql = "SELECT * FROM foods WHERE id ='$id_prd' ";
            $result = mysqli_query($conn, $sql);
            $rs = mysqli_fetch_assoc($result);

            $_SESSION['sess_id'][$i] = $rs['id'];
            $_SESSION['sess_name'][$i] = $rs['title'];
            $_SESSION['sess_price'][$i] = $rs['price'];
            $_SESSION['sess_num'][$i] += 1;
        }
    }
}
// กรณี foods id มีการยังไม่ได้เลือกใส่รถเข็นระบบจะกำหนดให้เท่ากับ 1
if ($check == 1) {
    // SELECT foods จากค่า method get id_prd
    $sql = "SELECT * FROM foods WHERE id ='$id_prd' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);

    $_SESSION['sess_id'][] = $rs['id']; // กำหนด sesion เป็น array id foods
    $_SESSION['sess_name'][] = $rs['title']; // กำหนด sesion เป็น array title
    $_SESSION['sess_price'][] = $rs['price']; // กำหนด sesion เป็น array price
    $_SESSION['sess_num'][] = 1; // กำหนด sesion เป็น array num
}
// redirect to my-basket.php
header("location:my-basket.php");
