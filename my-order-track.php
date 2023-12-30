<?php
include('config/constants.php');
include('config/function.php');
// ถ้าไม่มีการ login ไม่สามารถเข้าสู่หน้านี้ได้
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit; // ออกการทำงานเมื่อใ้ช้ function exit
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | ติดตามสถานะ</title>
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

    <!-- Header-->
    <!-- order detail section-->
    <?php ?>
    <section class="py-5">
        <div class="container px-2 my-2">
            <div class="mb-1 col-12"><a href="my-order.php" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> ออเดอร์ของฉัน</a>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="col-12 table-responsive">
                        <?php
                        $my_ord_number = $_GET['track_id'];
                        $sql_tracking = "SELECT * FROM foodtracking WHERE order_id = '$my_ord_number' ORDER BY status_date ASC ";
                        $result_tracking = mysqli_query($conn, $sql_tracking);
                        $num_tracking = mysqli_num_rows($result_tracking);
                        $no = 1;
                        if ($num_tracking > 0) {
                        ?>
                            <table id="datatable" class="table table-bordered nowrap">
                                <tbody>
                                    <tr class="text-center bg-danger text-light">
                                        <th colspan="4"><i class="fas fa-tags"></i> การติดตามสถานะอาหาร #<?= $my_ord_number ?></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>ข้อความจากทางร้าน</th>
                                        <th>สถานะ</th>
                                        <th>วันที่</th>
                                    </tr>
                                    <?php while ($rs_tracking = mysqli_fetch_assoc($result_tracking)) {
                                        $user_cancel = $rs_tracking['order_user_cancelled'];
                                        // ตรวจสอบการกดยกเลิกเป็นผู้ซื้อ หรือ ทางร้านอาหาร
                                        if ($user_cancel == 1) {
                                            $user_cancel = "โดยผู้ซื้อ";
                                        } else {
                                            $user_cancel = "โดยร้านอาหาร";
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $rs_tracking['remark'] ?></td>
                                            <td><?= $rs_tracking['status'] ?> (<?= $user_cancel ?>)</td>
                                            <td><?= DateInterFull($rs_tracking['status_date']) ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="alert alert-warning text-center"><strong>รอการยืนยันออเดอร์จากทางร้านอาหาร</strong></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div>
            </div>
        </div>
    </section>
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>