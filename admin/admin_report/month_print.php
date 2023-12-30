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
                        ยอดขายรายเดือน
                    </h2>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>เดือน</th>
                                <th>จำนวน (บาท)</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $sql_wallet_read = " SELECT DATE_FORMAT(DATE(foodtracking.status_date),'%m/%Y') AS stat_day, 
                                                        SUM(foods.price*orders.food_qty) AS sum_orders
                                                        FROM orders 
                                                        JOIN foodtracking 
                                                        ON orders.order_number = foodtracking.order_id
                                                        JOIN foods
                                                        ON foods.id = orders.food_id
                                                        WHERE foodtracking.status = 'อาหารของคุณเสร็จแล้ว'                                            
                                                        ORDER BY stat_day ASC ";
                            $result_wallet_read = mysqli_query($conn, $sql_wallet_read);
                            $nums_rows_read = mysqli_num_rows($result_wallet_read);
                            while ($rs_wallet_read = mysqli_fetch_assoc($result_wallet_read)) {
                            ?>
                                <tr>
                                    <td><?= $rs_wallet_read['stat_day'] ?></td>
                                    <td><?= number_format($rs_wallet_read['sum_orders'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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