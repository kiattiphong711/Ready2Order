<?php include('config/constants.php');
// หากตรวจพบ session ให้ redirect ไปหน้า my-account.php
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
    header('location:my-account.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | เข้าสู่ระบบ</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="dist/css/styles.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
</head>

<body class="bg-dark">
    <!-- Responsive navbar-->
    <!-- เมนูส่วนบนเริ่ม -->
    <?php include('layout/topmenu.php'); ?>
    <!-- เมนูส่วนบนสิ้นสุด -->
    <?php
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']); // รับค่า email แบบป้องกัน SQL Injection
        $password = md5(mysqli_real_escape_string($conn, $_POST['password'])); // password แบบป้องกัน SQL Injection

        $sql_check_users = "SELECT * FROM customer WHERE email = '$email' AND password = '$password' ";
        $result_check_users = mysqli_query($conn, $sql_check_users);
        $rs_check_users = mysqli_fetch_assoc($result_check_users);
        $rs_num_check = mysqli_num_rows($result_check_users);
        if ($rs_num_check > 0) {
            $_SESSION['mycustomer_id'] = $rs_check_users['id'];
            $_SESSION['mycustomer_status'] = true;
            header("refresh:3;url=my-account.php");
            $msg = "<div class=\"alert alert-success text-center\"><i class=\"far fa-check-circle\"></i> เข้าสู่ระบบสำเร็จ <br><i class=\"fas fa-hourglass-half\"></i> กำลังเข้าสู่ระบบ...</div>";
        } else {
            $msg = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</div>";
        }
    }
    ?>
    <!-- Features section-->
    <section class="py-5 bg-dark" id="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <?= $msg ?>
                    <?php if (!empty($_GET['action']) == "complete" && !isset($_POST['submit'])) {
                        echo "<div class=\"alert alert-success text-center\"><i class=\"far fa-check-circle\"></i> ลงทะเบียนสำเร็จแล้ว กรุณาเข้าสู่ระบบ</div>";
                    } ?>
                    <div class="login-form bg-light mt-4 p-4 rounded">
                        <form action="" method="post" class="row g-3">
                            <h4 class="text-center">Login</h4>
                            <div class="col-12">
                                <label>อีเมล</label>
                                <input type="email" name="email" class="form-control" placeholder="อีเมล" required>
                            </div>
                            <div class="col-12">
                                <label>รหัสผ่าน</label>
                                <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
                            </div>
                            <div class="col-12">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="submit" class="btn btn-dark">Login</button>
                                </div>
                            </div>
                        </form>
                        <hr class="mt-4">
                        <div class="col-12">
                            <p class="text-center mb-0">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dist/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
</body>

</html>