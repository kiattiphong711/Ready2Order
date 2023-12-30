<?php
if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']); // รับค่า full_name
    $username = mysqli_real_escape_string($conn, $_POST['username']); // รับค่า username
    $password1 = md5(mysqli_real_escape_string($conn, $_POST['password1'])); // password1
    $password2 = md5(mysqli_real_escape_string($conn, $_POST['password2'])); // password2
    // รหัสผ่าน กับ ยืนยันรหัสผ่านไม่ตรงกัน
    if ($password1 != $password2) {
        $msg .= "<div class=\"alert alert-danger\"> กรุณากรอกรหัสผ่าน และยืนยันรหัสผ่านให้ตรงกัน</div>";
    }
    // รหัสผ่าน กับ ยืนยันรหัสผ่านตรงกัน
    if ($password1 == $password2) {
        $sql_create_users = " INSERT INTO user_admin
        VALUES (NULL,'$full_name','$username','$password1')";
        $result_create_users = mysqli_query($conn, $sql_create_users);
        if ($result_create_users) {
            header("Location:index.php?mn=system&file=system_list");
        } else {
            $msg = "<div class=\"alert alert-danger\">ไม่สามารถเพิ่มข้อมูลได้</div>";
        }
    }
}
?>
<div class="col-md-12">
    <?= $msg ?>
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">เพิ่มผู้ดูแลระบบ</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="full_name">Full name</label>
                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full name" value="<?= $_POST['full_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="username">User name</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="User name" value="<?= $_POST['username'] ?>">
                </div>
                <div class="form-group">
                    <label for="password1">รหัสผ่าน</label>
                    <input type="password" class="form-control" name="password1" id="password1" placeholder="รหัสผ่าน">
                </div>
                <div class="form-group">
                    <label for="password2">ยืนยันรหัสผ่าน</label>
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="ยืนยันรหัสผ่าน">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>