<?php
if (isset($_GET['delete_id'])) {
    $id_del_category = $_GET['delete_id']; // รับค่า id และ select category
    $sql_del_category = " SELECT * FROM category WHERE id = $id_del_category ";
    $result_del_category = mysqli_query($conn, $sql_del_category);
    $rs_delete_users = mysqli_fetch_assoc($result_del_category);
    $fileupload = $rs_delete_users['image_name']; // ไฟล์รูปภาพ
    if ($fileupload != "") {
        // ไฟล์รูปภาพ ไม่เท่ากับค่าว่าง ทำการลบตาม path
        unlink("../images/category/$fileupload");
    }
    // ลบไอดี category
    $sql_dl = " DELETE FROM category WHERE id = $id_del_category ";
    $result_dl = mysqli_query($conn, $sql_dl);

    if ($result_dl) {
        header("Location: index.php?mn=category&file=category_list");
        exit;
    }
}
