<?php include('config/constants.php');
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit;
}
// เปลี่ยนรหัสผ่าน ของผู้ใช้งาน
if (isset($_POST['submit'])) {
    $edit_id = $_SESSION['mycustomer_id']; // จากค่า Session การ login
    $old_password = md5(mysqli_real_escape_string($conn, $_POST['old_password'])); // รับค่า old_password
    $new_password = md5(mysqli_real_escape_string($conn, $_POST['new_password'])); // รับค่า new_password
    $confirm_password = md5(mysqli_real_escape_string($conn, $_POST['confirm_password'])); // รับค่า confirm_password
    $sql_check_old = "SELECT * FROM customer WHERE id = $edit_id AND password = '$old_password' ";
    $result_check_old = mysqli_query($conn, $sql_check_old);
    $num_check_old = mysqli_num_rows($result_check_old);

    // ตรวจสอบรหัสผ่านเดิม
    if ($num_check_old > 0) {
        // ตรวจรหัสผ่าน และยืนยันรหัสผ่าน
        if ($new_password == $confirm_password) {
            $sql_users = " UPDATE customer SET password = '$new_password' WHERE id = $edit_id";
            $result_users = mysqli_query($conn, $sql_users);
            if ($result_users) {
                $msg = "<div class=\"alert alert-success\"><i class=\"far fa-check-circle\"></i> เปลี่ยนรหัสผ่านสำเร็จ <br><i class=\"fas fa-hourglass-half\"></i> กลับสู่บัญชีของฉัน...</div></div>";
                header("refresh:3;url=my-account.php");
            } else {
                $msg .= "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> ไม่สามารถแก้ไขข้อมูลได้</div>";
            }
        } else {
            $msg .= "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> รหัสผ่านใหม่กับยืนยันรหัสผ่านไม่ตรงกัน</div>";
        }
    } else {
        $msg .= "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> รหัสผ่านเดิมไม่ถูกต้อง</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | เปลี่ยนรหัสผ่าน</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="dist/css/styles.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
</head>

<body>
    <!-- Responsive navbar-->
    <!-- เมนูส่วนบนเริ่ม -->
    <?php include('layout/topmenu.php'); ?>
    <!-- เมนูส่วนบนสิ้นสุด -->
    <section class="content container mt-3">
        <?php
        // function วันที่ภาษาไทย
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
        $sql_account = "SELECT * FROM customer WHERE id = " . $_SESSION['mycustomer_id'];
        $result_account = mysqli_query($conn, $sql_account);
        $rs_account = mysqli_fetch_assoc($result_account);
        ?>
        <div class="container-fluid mb-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <i class="far fa-user-circle fa-4x"></i>
                            </div>
                            <h3 class="profile-username text-center"><?= $rs_account['firstname'] ?>&nbsp;&nbsp;<?= $rs_account['lastname'] ?></h3>

                            <p class="text-muted text-center"><?= $rs_account['mobilenumber'] ?></p>
                            <!-- menu for customer when login -->
                            <?php include('layout/my-left-menu.php'); ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><button class="btn btn-warning"><i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน</button></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <?= $msg ?>
                                    <form class="form-horizontal" method="post" action="">
                                        <div class="form-group row mb-3">
                                            <label for="old_password" class="col-sm-2 col-form-label">รหัสผ่านเดิม</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="old_password" name="old_password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="new_password" class="col-sm-2 col-form-label">รหัสผ่านใหม่</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="new_password" name="new_password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="confirm_password" class="col-sm-2 col-form-label">ยืนยันรหัสผ่าน</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="regdate" class="col-sm-2 col-form-label">&nbsp;</label>
                                            <div class="col-sm-10 d-grid gap-2">
                                                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-edit"></i> บันทึก</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div> <!-- /.require file admin -->

    </section>

    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dist/js/scripts.js"></script>
</body>

</html>