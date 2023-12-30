<?php
// ป้องกันการลบไอดี 1 ทิ้งกรณีกดผิด เพื่อป้องกันการ login ไม่ได้
if (isset($_GET['delete_id']) && $_GET['delete_id'] != 1) {
    $id_del_admin = $_GET['delete_id']; // รับค่า id และ select user_admin
    // ลบไอดี user_admin
    $sql_dl = " DELETE FROM user_admin WHERE id = '$id_del_admin' ";
    $result_dl = mysqli_query($conn, $sql_dl);
    if ($result_dl) {
        header("Location: index.php?mn=system&file=system_list");
        exit;
    }
} else {
    header("Location: index.php?mn=system&file=system_list&msg=ban");
}
