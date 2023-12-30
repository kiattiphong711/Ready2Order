<?php
include('config/constants.php');
include('config/function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ready2Order</title>
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
    <!-- ตัวค้นหาเริ่ม -->
    <header class="bg-dark py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center my-5">
                        <?php if (isset($_GET['track_number'])) {
                            $track_no = $_GET['track_number'];
                        } ?>
                        <form action="track-search.php" method="get">
                            <div class="input-group input-group-lg mb-3">
                                <input type="search" name="track_number" value="<?= $track_no ?>" class="form-control" placeholder="ค้นหาเลขสถานะอาหาร..." aria-label="ค้นหาเลขสถานะอาหาร..." aria-describedby="button-addon2" required>
                                <button type="submit" class="btn btn-danger" id="button-addon2"><i class="fas fa-tags"></i> ติดตามสถานะ</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['track_number'])) {
                            $search_track_number = mysqli_real_escape_string($conn, $_GET['track_number']);
                            $sql_track_number = " SELECT * FROM foodtracking WHERE order_id = '$search_track_number' GROUP BY order_id ORDER BY status_date ASC ";
                            $result_track_number = mysqli_query($conn, $sql_track_number);
                            $num_track_number = mysqli_num_rows($result_track_number);
                        ?>
                            <div class="form-text text-light" align="left">ผลการค้นหาพบ <?= number_format($num_track_number) ?> รายการ</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ตัวค้นหาสิ้นสุด -->
    <!-- Pricing section-->
    <section class="bg-foods bg-white">
        <div class="container my-5 py-5">
            <div class="col-12">
                <div class="table-responsive">
                    <?php
                    if (isset($_GET['track_number'])) {
                        $my_ord_number = $_GET['track_number'];
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
                            <?php $sql_ck_myorder = " SELECT * FROM orders WHERE order_number = '$my_ord_number' ";
                            $result_ck_myorder = mysqli_query($conn, $sql_ck_myorder);
                            $no_ck_myorder = mysqli_num_rows($result_ck_myorder);
                            ?>
                            <?php if ($no_ck_myorder > 0) { ?>
                                <div class="alert alert-warning text-center">ยังไม่ได้รับการยืนยัน</div>
                            <?php } else { ?>
                                <div class="alert alert-danger text-center">ไม่พบหมายเลขติดตามสถานะที่ค้นหา</div>
                            <?php } ?>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </section>
    <div style="height: 5rem;"></div>
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dist/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> -->
</body>

</html>