<?php
if (isset($_POST['submit'])) {
    $edit_id = $_POST['edit_id'];
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']); // รับค่า full_name
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']); // รับค่า username
    $sql_users = " UPDATE customer SET 
                                        firstname = '$firstname',
                                        lastname = '$lastname'
                                        WHERE id = $edit_id";
    $result_users = mysqli_query($conn, $sql_users);
    if ($result_users) {
        header("Location:index.php?mn=customer&file=customer_list");
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
    $sql = " SELECT * FROM customer WHERE id = '$edit_id' ";
    $result = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_assoc($result);
    ?>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">แก้ไขผู้ใช้งาน</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="firstname">ชื่อ</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="ชื่อ" value="<?= $rs['firstname'] ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">นามสกุล</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="นามสกุล" value="<?= $rs['lastname'] ?>">
                </div>
                <div class="form-group">
                    <label for="email">อีเมล</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="อีเมล" value="<?= $rs['email'] ?>" readonly="true">
                </div>
                <div class="form-group">
                    <label for="mobilenumber">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="เบอร์มือถือ" value="<?= $rs['mobilenumber'] ?>" readonly="true">
                </div>
                <div class="form-group">
                    <label for="regdate">วันที่ลงทะเบียน</label>
                    <input type="text" class="form-control" name="regdate" id="regdate" placeholder="วันที่ลงทะเบียน" value="<?= DateThaiFull($rs['regdate']) ?>" readonly="true">
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