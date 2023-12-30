<nav class="navbar navbar-expand-lg bg-white">
    <div class="container px-5">
        <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Ready2Order Logo"></a>
        <button class="navbar-toggler border border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-bars text-secondary fa-lg"></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-ready2orders">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">หน้าหลัก</a></li>
                <li class="nav-item"><a class="nav-link" href="categories.php">รายการอาหาร</a></li>
                <li class="nav-item"><a class="nav-link" href="foods.php">เมนูอาหาร</a></li>
                <?php
                if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
                ?>
                    <li class="nav-item"><a class="nav-link" href="my-order.php">ออเดอร์ของฉัน</a></li>
                    <li class="nav-item dropdown">
                        <!-- แสดง firstname บน Dropdown menu -->
                        <?php $sql_myprofile = "SELECT firstname FROM customer WHERE id = " . $_SESSION['mycustomer_id'];
                        $result_myprofile = mysqli_query($conn, $sql_myprofile);
                        $rs_myprofile = mysqli_fetch_assoc($result_myprofile);
                        ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $rs_myprofile['firstname'] ?>
                        </a>
                        <ul class="dropdown-menu mb-1" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="my-account.php">บัญชีของฉัน</a></li>
                            <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="btn btn-danger text-light mb-1 mr-1" href="my-basket.php"><i class="fas fa-shopping-cart"></i> รถเข็น</a></li>
                <?php
                } else {
                ?>
                    <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">เข้าสู่ระบบ</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>