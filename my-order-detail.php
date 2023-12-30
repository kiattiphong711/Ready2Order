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
    <title>R2O | รายละเอียดคำสั่งซื้อ</title>
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
                <?php $sql_order = "SELECT * FROM orders WHERE order_number = " . $_GET['order_id'];
                $result_order = mysqli_query($conn, $sql_order);
                $rs_order = mysqli_fetch_assoc($result_order);
                ?>
                <h5 class="card-header bg-dark text-light text-center"><i class="far fa-file-alt"></i> #<?= $rs_order['order_number'] ?></h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="border-0">
                                <tr class="border-0">
                                    <th class="border-0">เลขออเดอร์ #</th>
                                    <th class="border-0"><?= $rs_order['order_number'] ?></th>
                                    <th class="border-0">วันที่สั่งซื้อ</th>
                                    <th class="border-0"><?= DateInterFull($rs_order['order_date']) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="line-height: 80px;">
                                    <td class="border-0">สถานะออเดอร์</td>
                                    <td class="border-0 text-left" colspan="3">
                                        <?php
                                        $ord_numbers = $rs_order['order_number'];
                                        $sql_checktrack = "SELECT * FROM foodtracking WHERE order_id = '$ord_numbers' ORDER BY status_date DESC";
                                        $result_checktrack = mysqli_query($conn, $sql_checktrack);
                                        $rs_checktrack = mysqli_fetch_assoc($result_checktrack);
                                        $num_checktrack = mysqli_num_rows($result_checktrack);
                                        $mystatus_track = $rs_checktrack['status'];
                                        if ($num_checktrack == 0) {
                                            echo "รอการยืนยันสั่งซื้อ";
                                        } else {
                                            echo $mystatus_track;
                                        }
                                        ?> <a class="btn btn-sm btn-danger" href="my-order-track.php?track_id=<?= $ord_numbers ?>"><i class="fas fa-tags"></i> ติดตามสถานะ</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-12 text-center">
                            <a href="my-invoice.php?oid=<?= $rs_order['order_number'] ?>" target="_blank" class="btn btn-dark mt-1"><i class="fas fa-file-invoice"></i> บิลออเดอร์</a>
                            <a href="my-cancel-order.php?oid=<?= $rs_order['order_number'] ?>" class="btn btn-danger mt-1"><i class="fas fa-window-close"></i> ยกเลิกออเดอร์นี้</a>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <hr>
            </div>
            <div class="card mb-5">
                <h5 class="card-header bg-dark text-light text-center"><i class="far fa-file-alt"></i> รายละเอียดออเดอร์</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="border-0">
                                <tr class="border-0">
                                    <th class="border-0">#</th>
                                    <th class="border-0">เมนูอาหาร</th>
                                    <th class="border-0">จำนวน</th>
                                    <th class="border-0">ราคาต่อหน่วย</th>
                                    <th class="border-0">รวม</th>
                                    <th class="border-0">คำสั่งพิเศษ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql_order2 = "SELECT * FROM orders WHERE order_number = " . $_GET['order_id'] . " ORDER BY id ASC ";
                                $result_order2 = mysqli_query($conn, $sql_order2);
                                while ($rs_order2 = mysqli_fetch_assoc($result_order2)) {
                                    $sql_img = " SELECT * FROM foods WHERE id = " . $rs_order2['food_id'];
                                    $result_img = mysqli_query($conn, $sql_img);
                                    $rs_foods = mysqli_fetch_assoc($result_img);
                                    $sum_order = $rs_foods['price'] * $rs_order2['food_qty'];
                                    $total_order = $total_order + $sum_order;
                                ?>
                                    <tr style="line-height: 80px;">
                                        <td class="border-0"><img class="rounded" src="images/food/<?= $rs_foods['image_name'] ?>" alt="ข้าวผัด" width="50px" height="50px"></td>
                                        <td class="border-0"><?= $rs_foods['title'] ?></td>
                                        <td class="border-0"><?= number_format($rs_order2['food_qty']) ?></td>
                                        <td class="border-0"><?= number_format($rs_foods['price']) ?></td>
                                        <td class="border-0"><?= number_format($sum_order) ?></td>
                                        <td class="border-0"><?= $rs_order2['special'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <thead class="bg-dark text-light">
                                <tr>
                                    <th class="border-0" colspan="3">&nbsp;</th>
                                    <th class="border-0"><strong>รวม</strong></th>
                                    <th class="border-0" colspan="2">฿<?= number_format($total_order) ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>