<div class="row">
    <div class="col-12 mb-3">
        <a href="?mn=report&file=report_best_day" class="btn btn-primary btn-icon-split">
            <span class="icon">
                <i class="fas fa-calendar-day"></i>
            </span>
            <span class="text">รายการขายดีประจำวัน</span>
        </a>
        <a href="?mn=report&file=report_best_month" class="btn btn-warning btn-icon-split">
            <span class="icon">
                <i class="fas fa-calendar-week"></i>
            </span>
            <span class="text">รายการขายดีประจำเดือน</span>
        </a>
        <a href="admin_report/best_day_print.php" target="_blank" class="btn btn-dark btn-icon-split">
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
                <h4>รายการขายดีประจำวัน</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-3">
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
                        <table class="table table-striped text-center" cellspacing="0">
                            <thead class="thead-dark">
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
                                        <td><img src="../images/food/<?= $rs_best_day['image_name'] ?>" width="80px" class="rounded" alt="<?= $rs_best_day['title'] ?>"></td>
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
                        <div class="alert alert-dark text-center">ไม่พบรายการขายดีประจำวันนี้</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>