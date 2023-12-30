<?php
if (isset($_POST['submit'])) {
    $edit_id = $_POST['edit_id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']); // รับค่า full_name
    $username = mysqli_real_escape_string($conn, $_POST['username']); // รับค่า username
    $sql_update_users = " UPDATE user_admin SET 
                                        full_name = '$full_name',
                                        username = '$username'
                                        WHERE id = $edit_id";
    $result_update_users = mysqli_query($conn, $sql_update_users);
    if ($result_update_users) {
        header("Location:index.php?mn=system&file=system_list");
    } else {
        $msg = "<div class=\"alert alert-danger\">ไม่สามารถแก้ไขข้อมูลได้</div>";
    }
}
?>
<div class="col-md-12">
    <?= $msg ?>
    <!-- general form elements -->
    <?php
    $edit_id = $_GET['edit_id'];
    $sql = " SELECT * FROM user_admin WHERE id = '$edit_id' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);
    ?>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">แก้ไขผู้ดูแลระบบ</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="full_name">Full name</label>
                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full name" value="<?= $rs['full_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="username">User name</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="User name" value="<?= $rs['username'] ?>">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <input type="hidden" name="edit_id" value="<?= $rs['id'] ?>">
                <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>