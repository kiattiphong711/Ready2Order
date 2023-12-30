<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | สมัครสมาชิก</title>
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
    <?php
    if (isset($_POST['submit'])) {
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']); // รับค่า firstname แบบป้องกัน SQL Injection
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']); // รับค่า lastname แบบป้องกัน SQL Injection
        $mobilenumber = mysqli_real_escape_string($conn, $_POST['mobilenumber']); // รับค่า mobilenumber แบบป้องกัน SQL Injection
        $email = mysqli_real_escape_string($conn, $_POST['email']); // รับค่า email แบบป้องกัน SQL Injection
        $password1 = md5(mysqli_real_escape_string($conn, $_POST['password'])); // password แบบป้องกัน SQL Injection
        $password2 = md5(mysqli_real_escape_string($conn, $_POST['confirmpassword'])); // confirmpassword แบบป้องกัน SQL Injection
        // รหัสผ่าน กับ ยืนยันรหัสผ่านไม่ตรงกัน
        if ($password1 != $password2) {
            $msg .= "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> กรุณากรอกรหัสผ่าน และยืนยันรหัสผ่านให้ตรงกัน</div>";
        }
        // ตรวจสอบเมล์ที่สมัครไม่ให้ซ้ำกัน
        $sql_checkMail = "SELECT * FROM customer WHERE email = '$email'";
        $result_checkMail = mysqli_query($conn, $sql_checkMail);
        $num_checkMail = mysqli_num_rows($result_checkMail); // ตรวจจำนวนแถวว่าเมล์ซ้ำกี่อัน

        if ($num_checkMail > 0) {
            $msg = "<div class=\"alert alert-danger\"><i class= \"fas fa-exclamation-circle\"></i> อีเมลนี้ถูกลงทะเบียนไปแล้ว</div>";
        }

        // รหัสผ่าน กับ ยืนยันรหัสผ่านตรงกัน;
        if ($password1 == $password2 && $num_checkMail == 0) {
            $sql_create_users = " INSERT INTO customer
        VALUES (NULL,'$firstname','$lastname','$email','$mobilenumber','$password1',NULL)";
            $result_create_users = mysqli_query($conn, $sql_create_users);
            if ($result_create_users) {
                header("refresh:3;url=login.php?action=complete");
                $msg = "<div class=\"alert alert-success\"><i class=\"far fa-check-circle\"></i> ลงทะเบียนเป็นสมาชิกสำเร็จ <i class=\"fas fa-hourglass-half\"></i> กรุณาเข้าสู่ระบบ...</div>";
            } else {
                $msg = "<div class=\"alert alert-danger\"><i class=\"fas fa-exclamation-circle\"></i> ไม่สามารถลงทะเบียนเป็นสมาชิกได้</div>";
            }
        }
    }
    ?>
    <!-- Features section-->
    <section class="bg-light py-5 mb-5">
        <div class="container px-5 my-5 px-5">
            <div class="text-center mb-5">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="far fa-registered"></i></div>
                <h2 class="fw-bolder">สมัครสมาชิก</h2>
                <p class="lead mb-0">เพื่อใช้บริการสั่งอาหาร</p>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <!-- to get an API token!-->
                    <form id="contactForm" data-sb-form-api-token="API_TOKEN" action="" method="post" disabled>
                        <!-- This is what your users will see when the form-->
                        <!-- ตรวจสอบ Eror -->
                        <?= $msg ?>
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="firstname" name="firstname" value="<?= $_POST['firstname'] ?>" type="text" placeholder="กรอกชื่อ..." data-sb-validations="required" data-sb-can-submit="no">
                            <label for="firstname">ชื่อ</label>
                            <div class="invalid-feedback" data-sb-feedback="firstname:required">กรุณากรอกชื่อ</div>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="lastname" name="lastname" value="<?= $_POST['lastname'] ?>" type="text" placeholder="กรอกนามสกุล..." data-sb-validations="required" data-sb-can-submit="no">
                            <label for="lastname">นามสกุล</label>
                            <div class="invalid-feedback" data-sb-feedback="lastname:required">กรุณากรอกนามสกุล</div>
                        </div>
                        <!-- Phone number input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="mobilenumber" name="mobilenumber" value="<?= $_POST['mobilenumber'] ?>" type="tel" placeholder="กรอกเบอร์โทรศัพท์..." data-sb-validations="required" data-sb-can-submit="no">
                            <label for="mobilenumber">เบอร์โทรศัพท์</label>
                            <div class="invalid-feedback" data-sb-feedback="mobilenumber:required">กรุณากรอกเบอร์โทรศัพท์</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email" value="<?= $_POST['email'] ?>" placeholder="กรอกอีเมล..." data-sb-validations="required,email" data-sb-can-submit="no" autocomplete="username">
                            <label for="email">อีเมล</label>
                            <div class="invalid-feedback d-none" data-sb-feedback="email:required">กรุณากรอกอีเมล</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">กรุณากรอกอีเมลให้ถูกต้อง</div>
                        </div>

                        <!-- Password input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="password" type="password" placeholder="กรอกรหัสผ่าน..." data-sb-validations="required" data-sb-can-submit="no" autocomplete="new-password">
                            <label for="password">รหัสผ่าน</label>
                            <div class="invalid-feedback" data-sb-feedback="password:required">กรุณากรอกรหัสผ่าน</div>
                        </div>

                        <!-- ConfirmPasswordinput-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="กรอกยืนยันรหัสผ่าน..." data-sb-validations="required" data-sb-can-submit="no" autocomplete="new-password">
                            <label for="confirmpassword">ยืนยันรหัสผ่าน</label>
                            <div class="invalid-feedback" data-sb-feedback="confirmpassword:required">กรุณากรอกยืนยันรหัสผ่าน</div>
                        </div>
                        <div class="d-grid">
                            <!-- ใช้ดักค่าว่าง ไม่ต้องลบ -->
                            <input type="hidden" id="submitButton">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" id="submit">ลงทะเบียน</button>
                        </div>
                        <!-- Submit success message-->

                        <!-- has successfully submitted-->
                        <!-- ใช้ดักค่าว่าง ไม่ต้องลบ -->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder alert alert-success"></div>
                            </div>
                        </div>
                        <!---->
                        <!-- Submit error message-->
                        <!-- an error submitting the form-->
                        <!-- ใช้ดักค่าว่าง ไม่ต้องลบ -->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center alert alert-danger mb-3"></div>
                        </div>
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- Submit Button-->
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- sb-forms js-framework ใช้ตรวจสอบค่าว่างก่อนทำการลงทะเบียน -->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>