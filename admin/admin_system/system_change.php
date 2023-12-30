<?php
if (isset($_POST['submit'])) {
    $change_id = $_POST['id'];
    $current_password = md5(mysqli_real_escape_string($conn, $_POST['current_password'])); // รับค่า current_password
    $new_password = md5(mysqli_real_escape_string($conn, $_POST['new_password'])); // รับค่า new_password
    $confirm_password = md5(mysqli_real_escape_string($conn, $_POST['confirm_password'])); // รับค่า confirm_password

    // check database uuser_admin 
    $sql_admin = "SELECT * FROM user_admin WHERE id = '$change_id' ";
    $result_admin = mysqli_query($conn, $sql_admin);
    $rs_admin = mysqli_fetch_assoc($result_admin);

    if ($rs_admin['password'] == $current_password && $new_password == $confirm_password) {
        $sql_change_users = " UPDATE user_admin SET 
        password = '$new_password'
        WHERE id = $change_id";
        $result_change_users = mysqli_query($conn, $sql_change_users);
        if ($result_change_users) {
            header("Location:index.php?mn=system&file=system_list");
        } else {
            $msg = "<div class=\"alert alert-danger\">ไม่สามารถแก้ไขข้อมูลได้</div>";
        }
    } else {
        $msg = "<div class=\"alert alert-danger\">กรุณากรอกรหัสผ่านเดิม หรือกรอกรหัสผ่านใหม่ให้ตรงกัน</div>";
    }
}
?>
<div class="col-md-12">
    <?= $msg ?>
    <!-- general form elements -->
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">เปลี่ยนรหัสผ่าน</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="current_password">รหัสผ่านเดิม</label>
                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="รหัสผ่านเดิม">
                </div>
                <hr>
                <div class="form-group">
                    <label for="new_password">รหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="รหัสผ่านใหม่">
                </div>
                <div class="form-group">
                    <label for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="ยืนยันรหัสผ่านใหม่">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <input type="hidden" name="id" value="<?= $_GET['change_id'] ?>">
                <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>