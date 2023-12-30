<?php
include('config/constants.php');
// ถ้าไม่มีการ login ไม่สามารถเข้าสู่หน้านี้ได้
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit; // ออกการทำงานเมื่อใ้ช้ function exit
}

/* หาก submit ยกเลิก ให้ทำการเพิ่มข้อมูลลงในตาราง foodtracking
order_id,reason_cancel เหตุผล,order_user_cancelled  ยกเลิกโดยลูกค้า ให้มีค่าเท่ากับ 1
*/
if (isset($_POST['submit'])) {
    $reason_cancel = $_POST['reason_cancel'];
    $order_id = $_POST['order_id'];
    $sql_upstatus = " INSERT INTO foodtracking SET
                    order_id = '$order_id',
                    remark = '$reason_cancel',
                    status = 'ยกเลิกออเดอร์แล้ว',
                    order_user_cancelled ='1' ";
    $result_upstatus = mysqli_query($conn, $sql_upstatus);

    // ตารางสถานะ order_status_detail อัปเดตเป็นสถานะล่าสุด
    $sql_status_detail = " UPDATE order_status_detail SET
                        order_final_status = 'ยกเลิกออเดอร์แล้ว'
                        WHERE order_number = '$order_id'
                        ";
    $result_status_detail = mysqli_query($conn, $sql_status_detail);

    if ($result_upstatus) {
        // เพิ่มสำเร็จมีแจ้งบอก
        $msg = "<div class=\"alert alert-success\">ระบบยกเลิกออเดอร์เรียบร้อย</div>";
    } else {
        // เพิ่มไม่สำเร็จอาจเพราะ syntax error
        $msg = "<div class=\"alert alert-danger\">เกิดข้อผิดพลาดไม่สามารยกเลิกออเดอร์ได้</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | ยกเลิกคำสั่งซื้อ</title>
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
            <div class="mb-1 col-12"><a href="my-order-detail.php?order_id=<?= $_GET['oid'] ?>" class="btn btn-primary"><i class="far fa-file-alt"></i> กลับไปที่ออเดอร์นี้</a>
            </div>
            <?= $msg ?>
            <div class="card mb-3">
                <?php
                // รับค่า $_GET['oid'] เพื่อมาตรวจสอบ orders และ foodtracking ว่าสถานะในตาราง เป็นค่าว่าง หรือ มีสถานะใด
                $sql_order = "SELECT * FROM orders WHERE order_number = " . $_GET['oid'];
                $result_order = mysqli_query($conn, $sql_order);
                $rs_order = mysqli_fetch_assoc($result_order);
                // ตาราง foodtracking
                $sql_foodtracking = "SELECT * FROM foodtracking WHERE order_id = " . $rs_order['order_number'] . " ORDER BY status_date ASC";
                $result_foodtracking = mysqli_query($conn, $sql_foodtracking);
                // นับค่าในแถว
                $num_foodtracking = mysqli_num_rows($result_foodtracking);
                ?>
                <h5 class="card-header bg-danger text-light text-center"><i class="far fa-file-alt"></i> ยกเลิกคำสั่งซื้อ #<?= $rs_order['order_number'] ?></h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="border-0">
                                <tr class="border-0">
                                    <th class="border-0">หมายเลขคำสั่งซื้อ #</th>
                                    <th class="border-0">สถานะล่าสุด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- รอการยืนยันจากทางร้าน ถ้าไม่พบสถานะ หรือเป็นค่าว่าง กำหนดให้เป็นสถานะ "รอการยืนยัน"-->
                                <?php if ($num_foodtracking == 0) { ?>
                                    <tr>
                                        <td class="border-0"><?= $rs_order['order_number'] ?></td>
                                        <td class="border-0">รอการยืนยันออเดอร์</td>
                                    </tr>
                                <?php } ?>
                                <!-- สถานะวนลูปจากตาราง  foodtracking ตามไทม์ไลน์ที่กดสถานะ -->
                                <?php
                                while ($rs_foodtracking = mysqli_fetch_assoc($result_foodtracking)) {
                                ?>
                                    <tr>
                                        <td class="border-0"><?= $rs_order['order_number'] ?></td>
                                        <td class="border-0"><?= $rs_foodtracking['status'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-12 text-center">
                            <?php
                            // กรณียกเลิกไปแล้ว จะทำการตรวจสอบ foodtracking ว่ามี สถานะ กำลังทำอาหาร อาหารของคุณเสร็จแล้ว ยกเลิกออเดอร์แล้ว  จะไม่สามารถแสดง form นี้
                            $oid_number = $_GET['oid'];
                            $sql_c_cancel = "SELECT order_final_status as 'status' FROM order_status_detail WHERE order_number = '$oid_number' ";
                            $result_c_cancel = mysqli_query($conn, $sql_c_cancel);
                            $rs_c_cancel = mysqli_fetch_assoc($result_c_cancel);
                            if ($rs_c_cancel['status'] != "กำลังทำอาหาร" and $rs_c_cancel['status'] != "อาหารของคุณเสร็จแล้ว" and $rs_c_cancel['status'] != "ยกเลิกออเดอร์แล้ว") {
                            ?>
                                <form class="form-horizontal" method="post" action="">
                                    <div class="form-group row mb-3">
                                        <label for="firstname" class="col-sm-2 col-form-label"><strong>เหตุผลยกเลิกออเดอร์</strong></label>
                                        <div class="col-sm-10">
                                            <textarea name="reason_cancel" id="reason_cancel" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="regdate" class="col-sm-2 col-form-label">&nbsp;</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="order_id" value="<?= $_GET['oid'] ?>">
                                            <button type="submit" name="submit" value="submit" class="btn btn-danger"><i class="fas fa-window-close"></i> ยืนยันยกเลิก</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- หากพบสถานะว่ายกเลิกจะไม่แสดง form การยกเลิก -->
                            <?php } else { ?>
                                <div class="text-danger">ไม่สามารถยกเลิกคำสั่งซื้อได้เนื่องจาก<?= $rs_c_cancel['status'] ?></div>
                            <?php } ?>
                        </div>
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