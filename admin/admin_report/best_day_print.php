<?php
include('../../config/constants.php');
if ($_SESSION['user_admin'] != "" && $_SESSION['status_login'] === true) {
} else {
    header('location:login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class=" far fa-file-alt"></i> READY2Order
                        <small class="float-right">วันที่ <?= date('d/m/Y') ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header text-center">
                        รายการขายดีประจำวัน
                    </h2>
                </div>
                <div class="col-12 table-responsive">
                    <?php
                    $day_nows = date('d');
                    $sql_best_day = " SELECT foods.id,foods.title,foods.image_name,foods.price,SUM(orders.food_qty) AS sum_qty
                            FROM foods
                            INNER JOIN orders ON foods.id= orders.food_id
                            INNER JOIN order_status_detail ON order_status_detail.order_number=orders.order_number
                            WHERE DAY(order_status_detail.order_status_time)='$day_nows' AND order_status_detail.order_final_status = 'อาหารของคุณเสร็จแล้ว'
                            GROUP BY foods.id
                            ORDER BY sum_qty DESC LIMIT 0,1";
                    $result_best_day = mysqli_query($conn, $sql_best_day);
                    $num_best_day = mysqli_num_rows($result_best_day);
                    if ($num_best_day > 0) {
                    ?>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>รูปอาหาร</th>
                                    <th>เมนูอาหาร</th>
                                    <th>จำนวน</th>
                                    <th>ราคา</th>
                                    <th>ยอดขาย</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($rs_best_day = mysqli_fetch_assoc($result_best_day)) {

                                ?>
                                    <tr>
                                        <td><?= date('d/m/Y') ?></td>
                                        <td><img src="../../images/food/<?= $rs_best_day['image_name'] ?>" width="80px" class="rounded" alt="<?= $rs_best_day['title'] ?>"></td>
                                        <td><?= $rs_best_day['title'] ?></td>
                                        <td><?= number_format($rs_best_day['sum_qty']) ?></td>
                                        <td><?= number_format($rs_best_day['price']) ?></td>
                                        <td><?= number_format($rs_best_day['sum_qty'] * $rs_best_day['price']) ?></td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="alert alert-white text-center">ไม่พบรายการขายดีประจำวันนี้</div>
                    <?php } ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>