<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php
            // select category นับด้วย function mysqli_num_rows
            $sql_category = "SELECT * FROM category ORDER BY id ASC";
            $result_category = mysqli_query($conn, $sql_category);
            $num_category = mysqli_num_rows($result_category);
            ?>
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3><?= number_format($num_category) ?></h3>

                    <p>ประเภทอาหาร</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-ul text-white"></i>
                </div>
                <a href="index.php?mn=category&file=category_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- small box -->
        <?php
        // select category นับด้วย function mysqli_num_rows
        $sql_food = "SELECT * FROM foods ORDER BY id ASC";
        $result_food = mysqli_query($conn, $sql_food);
        $num_food = mysqli_num_rows($result_food);
        ?>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3><?= number_format($num_food) ?></h3>

                    <p>อาหาร</p>
                </div>
                <div class="icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <a href="index.php?mn=food&file=food_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= number_format($num_notify) ?></h3>

                    <p>ออเดอร์ใหม่</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="index.php?mn=order&file=order_waiting" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <?php $sql_od_now = " SELECT DATE_FORMAT(DATE(order_status_detail.order_status_time),'%d/%m/%Y') AS stat_day, SUM(foods.price*orders.food_qty) AS sum_orders
                                                    FROM orders 
                                                    JOIN order_status_detail 
                                                    ON orders.order_number = order_status_detail.order_number
                                                    JOIN foods
                                                    ON orders.food_id = foods.id
                                                    WHERE order_status_detail.order_final_status = 'อาหารของคุณเสร็จแล้ว'
                                                    GROUP BY orders.order_number
                                                    ORDER BY order_status_detail.order_status_time DESC ";
        $result_od_now = mysqli_query($conn, $sql_od_now);
        $rs_od_now = mysqli_fetch_assoc($result_od_now);
        ?>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($rs_od_now['sum_orders']) ?><sup style="font-size: 20px">฿</sup></h3>

                    <p>ยอดขายล่าสุด</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?mn=order&file=order_finish" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <?php $sql_od_today = " SELECT DATE_FORMAT(DATE(order_status_detail.order_status_time),'%d/%m/%Y') AS stat_day, SUM(foods.price*orders.food_qty) AS sum_orders
                                                    FROM orders 
                                                    JOIN order_status_detail 
                                                    ON orders.order_number = order_status_detail.order_number
                                                    JOIN foods
                                                    ON orders.food_id = foods.id
                                                    WHERE order_status_detail.order_final_status = 'อาหารของคุณเสร็จแล้ว'
                                                    GROUP BY DATE(order_status_detail.order_status_time)
                                                    ORDER BY stat_day DESC ";
        $result_od_today = mysqli_query($conn, $sql_od_today);
        $rs_od_today = mysqli_fetch_assoc($result_od_today);
        ?>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($rs_od_today['sum_orders']) ?><sup style="font-size: 20px">฿</sup></h3>
                    <p>ยอดขายวันนี้</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?mn=report&file=report_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <?php $sql_od_most = " SELECT SUM(foods.price*orders.food_qty) AS sum_orders
                                FROM orders 
                                JOIN foodtracking 
                                ON orders.order_number = foodtracking.order_id
                                JOIN foods
                                ON foods.id = orders.food_id
                                WHERE foodtracking.status = 'อาหารของคุณเสร็จแล้ว' ";
        $result_od_most = mysqli_query($conn, $sql_od_most);
        $rs_od_most = mysqli_fetch_assoc($result_od_most);
        ?>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($rs_od_most['sum_orders']) ?><sup style="font-size: 20px">฿</sup></h3>

                    <p>ยอดขายทั้งหมด</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?mn=report&file=report_year" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php
            // select category นับด้วย function mysqli_num_rows
            $sql_customer = "SELECT * FROM customer ORDER BY id ASC";
            $result_customer = mysqli_query($conn, $sql_customer);
            $num_customer = mysqli_num_rows($result_customer);
            ?>
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= number_format($num_customer) ?></h3>

                    <p>ผู้ใช้งาน</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="index.php?mn=customer&file=customer_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php
            // select category นับด้วย function mysqli_num_rows
            $sql_admin = "SELECT * FROM user_admin ORDER BY id ASC";
            $result_admin = mysqli_query($conn, $sql_admin);
            $num_admin = mysqli_num_rows($result_admin);
            ?>
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= number_format($num_admin) ?></h3>

                    <p>ผู้ดูแลระบบ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-lock"></i>
                </div>
                <a href="index.php?mn=system&file=system_list" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
</div>