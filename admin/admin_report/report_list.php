<div class="row">
    <div class="col-12 mb-3">
        <a href="?mn=report&file=report_list" class="btn btn-primary btn-icon-split">
            <span class="icon">
                <i class="fas fa-calendar-day"></i>
            </span>
            <span class="text">รายงานออเดอร์รายวัน</span>
        </a>
        <a href="?mn=report&file=report_month" class="btn btn-warning btn-icon-split">
            <span class="icon">
                <i class="fas fa-calendar-week"></i>
            </span>
            <span class="text">รายงานออเดอร์รายเดือน</span>
        </a>
        <a href="?mn=report&file=report_year" class="btn btn-success btn-icon-split">
            <span class="icon">
                <i class="fas fa-calendar-alt"></i>
            </span>
            <span class="text">รายงานออเดอร์รายปี</span>
        </a>
        <a href="admin_report/day_print.php" target="_blank" class="btn btn-dark btn-icon-split">
            <span class="icon">
                <i class="fas fa-print"></i>
            </span>
            <span class="text"> พิมพ์</span>
        </a>
    </div>
    <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
        <!-- Page Heading -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header bg-gradient-primary text-center">
                <h4>ออเดอร์จำแนกเป็นรายวัน</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-3">
                    <table class="table table-striped text-center" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>วันที่</th>
                                <th>จำนวน (บาท)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sql_wallet_read = " SELECT DATE_FORMAT(DATE(foodtracking.status_date),'%d/%m/%Y') AS stat_day, 
                                                        SUM(foods.price*orders.food_qty) AS sum_orders
                                                        FROM orders 
                                                        JOIN foodtracking 
                                                        ON orders.order_number = foodtracking.order_id
                                                        JOIN foods
                                                        ON foods.id = orders.food_id
                                                        WHERE foodtracking.status = 'อาหารของคุณเสร็จแล้ว'
                                                        GROUP BY DATE(foodtracking.status_date)
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
            </div>
        </div>
    </div>
</div>