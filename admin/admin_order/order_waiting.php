<div class="col-12 mb-3">
    <a href="?mn=order&file=order_waiting" class="btn btn-primary btn-icon-split">
        <span class="icon">
            <i class="far fa-circle nav-icon"></i>
        </span>
        <span class="text">รอการยืนยันออเดอร์</span>
    </a>
    <a href="?mn=order&file=order_confirm" class="btn btn-primary btn-icon-split">
        <span class="icon">
            <i class="far fa-circle nav-icon"></i>
        </span>
        <span class="text">รับออเดอร์</span>
    </a>
    <a href="?mn=order&file=order_working" class="btn btn-primary btn-icon-split">
        <span class="icon">
            <i class="far fa-circle nav-icon"></i>
        </span>
        <span class="text">กำลังทำอาหาร</span>
    </a>
    <a href="?mn=order&file=order_finish" class="btn btn-primary btn-icon-split">
        <span class="icon">
            <i class="far fa-circle nav-icon"></i>
        </span>
        <span class="text">อาหารของคุณเสร็จแล้ว</span>
    </a>
    <a href="?mn=order&file=order_cancel" class="btn btn-primary btn-icon-split">
        <span class="icon">
            <i class="far fa-circle nav-icon"></i>
        </span>
        <span class="text">ยกเลิกออเดอร์แล้ว</span>
    </a>
    <a href="?mn=order&file=order_list" class="btn btn-primary btn-icon-split">
        <span class="icon">
            <i class="far fa-circle nav-icon"></i>
        </span>
        <span class="text">ออเดอร์ทั้งหมด</span>
    </a>
</div>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th># เลขที่คำสั่งซื้อ</th>
                    <th>วันที่</th>
                    <th>ตัวจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php $sql_order = " SELECT
                                    customer.firstname,
                                    orders.order_number,
                                    order_status_detail.order_status_time,
                                    order_status_detail.order_final_status
                                    FROM customer
                                    JOIN orders
                                        ON orders.customer_id = customer.id
                                    JOIN order_status_detail
                                        ON order_status_detail.order_number = orders.order_number
                                        WHERE order_status_detail.order_final_status IS NULL 
                                        GROUP BY orders.order_number 
                                        ORDER BY order_status_detail.order_status_time DESC";
                $result_order = mysqli_query($conn, $sql_order);
                $num_order = mysqli_num_rows($result_order);
                $no = 1;
                if ($num_order > 0) {
                    while ($rs_order = mysqli_fetch_assoc($result_order)) {
                ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $rs_order['order_number'] ?></td>
                            <td><?= DateInterFull($rs_order['order_status_time']) ?></td>
                            <td>
                                <a href="index.php?mn=order&file=order_detail&view_id=<?= $rs_order['order_number'] ?>" class="btn btn-primary mb-1"><i class="fas fa-list-ul"></i> ดูรายละเอียด</a>
                            </td>
                        </tr>
                    <?php $no++;
                    } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="bg-white text-center">ยังไม่มีข้อข้อมูล</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>