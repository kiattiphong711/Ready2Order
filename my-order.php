<?php include('config/constants.php');
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit;
}
// คำนวณ หรือ ยืนยัน
if (!empty($_GET['event']) == "complete") {
    $order_generate = date("dmYHis"); // สร้าง order_number ด้วย วัน/เดือน/ปี ชั่วโมง นาที วินาที
    // เพิ่มข้อมูลลงตาราง order_address

    $cust_id = $_SESSION['mycustomer_id'];

    // เพิ่มรายละเอียดสถานะออเดอร์ล่าสุดลงใน order_status_detail
    $sql_in_add = " INSERT INTO order_status_detail SET
    customer_id ='$cust_id',
    order_number ='$order_generate' ";
    $result_in_add = mysqli_query($conn, $sql_in_add);

    for ($i = 0; $i < count($_SESSION['sess_id']); $i++) {

        $customer_id = $_SESSION['mycustomer_id'];
        $food_id = $_SESSION['sess_id'][$i];
        $food_qty = $_SESSION['sess_num'][$i];
        $order_number = $order_generate;
        $special = $_SESSION['sess_special'][$i];

        $sql_insert_order = "INSERT INTO orders SET
                    customer_id='$customer_id',
                    food_id='$food_id',
                    food_qty='$food_qty',
                    order_number='$order_number',
                    special='$special'
                ";
        $result_insert_order = mysqli_query($conn, $sql_insert_order);
        if ($result_insert_order) {
            header('location:my-order.php');
        }
    }
    unset($_SESSION['sess_id']);
    unset($_SESSION['sess_name']);
    unset($_SESSION['sess_price']);
    unset($_SESSION['sess_num']);
    unset($_SESSION['sess_special']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | ออเดอร์ของฉัน</title>
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

        <!-- require file customer account -->
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
            return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute:$strSeconds";
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
                                <li class="nav-item"><button class="btn btn-primary"><i class="fas fa-shopping-cart"></i> ออเดอร์ของฉัน</button></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <div class="col-12">
                                        <!-- My Order -->
                                        <?php
                                        $my_id = $_SESSION['mycustomer_id'];
                                        $sql_orders = " SELECT * FROM orders WHERE customer_id = '$my_id' GROUP BY order_number  ORDER BY order_date DESC ";
                                        $result_orders = mysqli_query($conn, $sql_orders);
                                        $num_orders = mysqli_num_rows($result_orders);
                                        if ($num_orders > 0) {
                                            while ($rs_orders = mysqli_fetch_assoc($result_orders)) {
                                        ?>
                                                <div class="card mb-2">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0"><i class="far fa-file-alt text-primary fa-7x"></i></div>
                                                            <div class="ms-4 w-100">
                                                                <p class="mb-1 text-danger"><strong><i class="far fa-calendar-alt"></i> วันที่สั่งซื้อ</strong> <?= DateThaiFull($rs_orders['order_date']) ?></p>
                                                                <div class="mbt-1"><strong>เลขออเดอร์ # <?= $rs_orders['order_number'] ?></strong></div>
                                                                <div class="row mt-1">
                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-xs-12">
                                                                        <?php
                                                                        $ord_nums = $rs_orders['order_number'];
                                                                        $sql_checktrack = "SELECT * FROM foodtracking WHERE order_id = '$ord_nums' ORDER BY status_date DESC ";
                                                                        $result_checktrack = mysqli_query($conn, $sql_checktrack);
                                                                        $rs_checktrack = mysqli_fetch_assoc($result_checktrack);
                                                                        $mystatus_track = $rs_checktrack['status'];
                                                                        ?>
                                                                        <?php if ($mystatus_track == "") { ?>
                                                                            <h4><span class="badge bg-secondary"><i class="fas fa-history"></i> ยังไม่ได้รับออเดอร์</span></h4>
                                                                        <?php } ?>
                                                                        <?php if ($mystatus_track == "รับออเดอร์") { ?>
                                                                            <h4><span class="badge bg-dark"><i class="fas fa-file-signature"></i> รับออเดอร์</span></h4>
                                                                        <?php } ?>
                                                                        <?php if ($mystatus_track == "กำลังทำอาหาร") { ?>
                                                                            <h4><span class="badge bg-warning"><i class="fas fa-mug-hot"></i> กำลังทำอาหาร</span></h4>
                                                                        <?php } ?>
                                                                        <?php if ($mystatus_track == "อาหารของคุณเสร็จแล้ว") { ?>
                                                                            <h4><span class="badge bg-success"><i class="fas fa-check-circle"></i> อาหารของคุณเสร็จแล้ว</span></h4>
                                                                        <?php } ?>
                                                                        <?php if ($mystatus_track == "ยกเลิกออเดอร์แล้ว") { ?>
                                                                            <h4><span class="badge bg-danger"><i class="fas fa-times-circle"></i> ยกเลิกออเดอร์แล้ว</span></h4>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-xs-12">
                                                                        <a href="my-order-detail.php?order_id=<?= $rs_orders['order_number'] ?>" class="btn btn-sm btn-primary"><i class="fas fa-info-circle"></i> รายละเอียด</button></a>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2"><a class="btn btn-sm btn-outline-danger" href="track-search.php?track_number=<?= $rs_orders['order_number'] ?>"><i class="fas fa-tags"></i> ติดตามออเดอร์</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-warning text-center"><i class="far fa-thumbs-up"></i> เลือกเมนูอาหารโดนใจใส่รถเข็นได้เลย <br> <a class="btn btn-primary" href="foods.php"><i class="fas fa-utensils"></i> Order Now</a></div>
                                        <?php } ?>
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