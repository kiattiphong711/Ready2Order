<?php
if (isset($_GET['delete_id'])) {
    $id_del_food = $_GET['delete_id']; // รับค่า id และ select food
    $sql_del_food = " SELECT * FROM foods WHERE id = $id_del_food ";
    $result_del_food = mysqli_query($conn, $sql_del_food);
    $rs_delete_users = mysqli_fetch_assoc($result_del_food);
    $fileupload = $rs_delete_users['image_name']; // ไฟล์รูปภาพ
    if ($fileupload != "") {
        // ไฟล์รูปภาพ ไม่เท่ากับค่าว่าง ทำการลบตาม path
        unlink("../images/food/$fileupload");
    }
    // ลบไอดี food
    $sql_dl = " DELETE FROM foods WHERE id = $id_del_food ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location: index.php?mn=food&file=food_list");
        exit;
    }
}
