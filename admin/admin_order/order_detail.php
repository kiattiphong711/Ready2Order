<div class="bg-white mb-3">
    <div class="row p-1">
        <div class="col-6 mt-3">
            <div class="table-responsive">
                <?php
                $ord_number = $_GET['view_id'];
                $sql_customer = " SELECT order_status_detail.order_number,customer.firstname,customer.lastname,customer.email,customer.mobilenumber,
                 order_status_detail.order_status_time,order_status_detail.order_final_status FROM customer 
                 JOIN order_status_detail
                 ON customer.id = order_status_detail.customer_id
                 WHERE order_status_detail.order_number = '$ord_number' ";
                $result_customer = mysqli_query($conn, $sql_customer);
                $rs_customer = mysqli_fetch_assoc($result_customer);
                if ($rs_customer['order_final_status'] == "") {
                    $order_final_status = "รอการยืนยันสั่งซื้อ";
                } else {
                    $order_final_status = $rs_customer['order_final_status'];
                }
                ?>
                <table class="table table-bordered border-1 text-nowrap">
                    <tbody>
                        <tr class="text-center">
                            <td colspan="2" class="bg-dark" style="font-size: 1.2rem;">
                                รายละเอียดผู้ใช้งาน</td>
                        </tr>
                        <tr>
                            <th>เลขที่คำสั่งซื้อ</th>
                            <td><?= $rs_customer['order_number'] ?></td>
                        </tr>
                        <tr>
                            <th>ชื่อ</th>
                            <td><?= $rs_customer['firstname'] ?></td>
                        </tr>
                        <tr>
                            <th>นามสกุล</th>
                            <td><?= $rs_customer['lastname'] ?></td>
                        </tr>
                        <tr>
                            <th>อีเมล</th>
                            <td><?= $rs_customer['email'] ?></td>
                        </tr>
                        <tr>
                            <th>เบอร์โทรศัพท์</th>
                            <td><?= $rs_customer['mobilenumber'] ?></td>
                        </tr>
                        <tr>
                            <th>วันที่สั่งซื้อ</th>
                            <!-- เรียกใช้ DateInterFull function เปลี่ยนวันที่แบบปกติอ่านง่าย วัน/เดือน/ปี เวลา-->
                            <td><?= DateInterFull($rs_customer['order_status_time']) ?></td>
                        </tr>
                        <tr>
                            <th>สถานะการสั่ง</th>
                            <td><?= $order_final_status ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6 mt-3">
            <?php $sql_order2 = "SELECT * FROM orders WHERE order_number = " . $_GET['view_id'] . " ORDER BY id ASC ";
            $result_order2 = mysqli_query($conn, $sql_order2);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered border-1 text-nowrap">
                    <tbody>
                        <tr class="text-center">
                            <td colspan="7" class="bg-dark">
                                <div style="font-size: 1.2rem;">รายละเอียดออเดอร์</div>
                            </td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>รูปอาหาร</th>
                            <th>เมนู</th>
                            <th class="text-center">จำนวน</th>
                            <th class="text-center">ราคาต่อหน่วย</th>
                            <th class="text-right">รวม</th>
                            <th>คำสั่งพิเศษ</th>
                        </tr>
                        <?php
                        while ($rs_order2 = mysqli_fetch_assoc($result_order2)) {
                            $sql_foods = " SELECT * FROM foods WHERE id = " . $rs_order2['food_id'];
                            $result_foods = mysqli_query($conn, $sql_foods);
                            $rs_foods = mysqli_fetch_assoc($result_foods);
                            $sum_order = $rs_foods['price'] * $rs_order2['food_qty'];
                            $total_order = $total_order + $sum_order; ?>
                            <tr>
                                <td>1</td>
                                <td><img src="../images/food/<?= $rs_foods['image_name'] ?>" class="rounded" width="60" height="40" alt=""></td>
                                <td><?= $rs_foods['title'] ?></td>
                                <td class="text-center"><?= number_format($rs_order2['food_qty']) ?></td>
                                <td class="text-center"><?= number_format($rs_foods['price']) ?></td>
                                <td class="text-right"><?= number_format($sum_order) ?></td>
                                <td class="text-left"><?= $rs_order2['special'] ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="bg-dark">
                            <th colspan="6" class="text-center border-right-0">รวมทั้งหมด</th>
                            <td class="text-right border-left-0">฿<?= number_format($total_order) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?php if (isset($_POST['submit'])) {
            $order_id = $_POST['order_id'];
            $remark = $_POST['remark'];
            $status = $_POST['status'];
            // ตารางสถานะ foodtracking
            $sql = " INSERT INTO foodtracking SET
                    order_id = '$order_id',
                    remark = '$remark',
                    status = '$status'
                ";
            $result = mysqli_query($conn, $sql);

            // ตารางสถานะ order_status_detail อัปเดตเป็นสถานะล่าสุด
            $sql_order_status_detail = " UPDATE order_status_detail SET
                    order_final_status = '$status'
                   WHERE order_number = '$order_id'
                ";
            $result_order_status_detail = mysqli_query($conn, $sql_order_status_detail);


            if ($result) {
                $msg = "<div class=\"alert alert-success\">อัปเดตสถานะสำเร็จ</div>";
            } else {
                $msg = "<div class=\"alert alert-danger\">ไม่สามารถอัปเดตสถานะได้</div>";
            }
        } ?>
        <?= $msg ?>
        <!-- Check order_final_status จาก order_status_detail ยกเลิก or อาหารของคุณเสร็จแล้ว ไม่แสดง  form นี้ -->
        <?php
        $sql_final = " SELECT order_final_status FROM order_status_detail WHERE order_number  = '$ord_number' ";
        $result_final = mysqli_query($conn, $sql_final);
        $rs_final = mysqli_fetch_assoc($result_final);
        // ถ้าสถานะเป็น อาหารของคุณเสร็จแล้ว และ ยกเลิกคำสั่งซื้อ เป็นการจบการทำงานไม่มี update status
        if ($rs_final['order_final_status'] != "อาหารของคุณเสร็จแล้ว" && $rs_final['order_final_status'] != "ยกเลิกออเดอร์แล้ว") { ?>
            <div class="card">
                <div class="card-header p-2 bg-primary">
                    <i class="fas fa-edit"></i> เปลี่ยนสถานะอาหาร
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal" method="post" action="">
                                <div class="form-group row mb-3">
                                    <label for="old_password" class="col-sm-2 col-form-label">ข้อความจากทางร้าน</label>
                                    <div class="col-sm-10">
                                        <textarea name="remark" id="remark" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="new_password" class="col-sm-2 col-form-label">จัดการสถานะ</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control" required="true">
                                            <option value="รับออเดอร์" selected="true">รับออเดอร์</option>
                                            <option value="ยกเลิกคำสั่งซื้อ">ยกเลิกออเดอร์แล้ว</option>
                                            <option value="กำลังทำอาหาร">กำลังทำอาหาร</option>
                                            <option value="อาหารของคุณเสร็จแล้ว">อาหารของคุณเสร็จแล้ว</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="regdate" class="col-sm-2 col-form-label">&nbsp;</label>
                                    <div class="col-sm-10 d-grid gap-2">
                                        <input type="hidden" name="order_id" value="<?= $ord_number ?>">
                                        <button type="submit" name="submit" value="submit" class="btn btn-warning"><i class="fas fa-edit"></i> อัปเดตสถานะ</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
        <?php } ?>
    </div>
    <div class="col-12 table-responsive">
        <?php $sql_tracking = "SELECT * FROM foodtracking WHERE order_id = '$ord_number' ORDER BY status_date ASC ";
        $result_tracking = mysqli_query($conn, $sql_tracking);
        $num_tracking = mysqli_num_rows($result_tracking);
        $no = 1;
        if ($num_tracking > 0) {
        ?>
            <table id="datatable" class="table table-bordered nowrap">
                <tbody>
                    <tr class="text-center bg-danger">
                        <th colspan="4"><i class="fas fa-tags"></i> การติดตามสถานะอาหาร</th>
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
                            $user_cancel = "โดยผู้ชื้อ";
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
        <?php } ?>
    </div>
</div>