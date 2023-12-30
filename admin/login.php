<?php include('../config/constants.php');
// ตรวจพบ session user_admin และ status_login หน้า login จะเข้า index อัตโนมัติ
if ($_SESSION['user_admin'] != "" && $_SESSION['status_login'] === true) {
    header('location:index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Signin Template · Bootstrap v5.1</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="https://getbootstrap.com/docs/5.1/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">


    <!-- Custom styles for this template -->
    <link href="../dist/css/signin.css" rel="stylesheet">
</head>

<body class="text-center bg-dark">
    <main class="form-signin">
        <!-- เปลี่ยนดีไซน์ใหม่เพื่อรองรับการย่อหน้าจอแบบมือถือได้ -->
        <?php
        //Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            //Process for login
            //1. Get the Data from login form
            $username = mysqli_real_escape_string($conn, $_POST['username']); // Protect SQL Injection ป้องกัน sql Injection 
            $password = mysqli_real_escape_string($conn, md5($_POST['password'])); // Protect SQL Injection ป้องกัน sql Injection

            //2. SQL to check whether the user with username and password exists or not
            $sql = "SELECT * FROM user_admin WHERE username='$username' AND password='$password'";

            //3. Execute the Query
            $res = mysqli_query($conn, $sql);
            $rs = mysqli_fetch_assoc($res);

            //4. Count rows to check whether the user exists or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //User Available and Login Success
                $msg = "<div class='alert alert-success'>Login Successful.</div>";
                $_SESSION['user_admin'] = $rs['full_name']; //To check whether the user is logged in or not and logout will unset it
                $_SESSION['status_login'] = true; // To

                //Redirect to Home Page/Dashboard
                header('location:index.php');
            } else {
                //User not Available and login Fail
                $msg = "<div class='alert alert-danger'>Username หรือ Password ผิดพลาด <br> โปรดตรวจสอบใหม่</div>";
            }
        }

        ?>
        <?php
        if ($msg != "") {
            echo $msg;
        }
        ?>
        <form action="" method="POST">
            <i class="fas fa-store text-white mb-2 fa-3x"></i>
            <h1 class="h3 mb-3 fw-normal text-white">LOGIN</h1>
            <div class="form-floating">
                <input type="text" class="form-control" name="username" id="floatingInput" placeholder="Username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit" value="Login">Login</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>