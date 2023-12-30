<?php
include('config/constants.php');
// ถ้าไม่มีการ login ไม่สามารถเข้าสู่หน้านี้ได้
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit; // ออกการทำงานเมื่อใ้ช้ function exit
}

// Delete by foods id session
if (!empty($_GET['del_id'])) {
    $prd_del[] = $_GET['del_id']; // มีการลบเมื่อรับค่าจาก del_id
    for ($i = 0; $i < count($_SESSION['sess_id']); $i++) {
        if (!in_array($_SESSION['sess_id'][$i], $prd_del)) {
            $temp_id[] = $_SESSION['sess_id'][$i];
            $temp_name[] = $_SESSION['sess_name'][$i];
            $temp_price[] = $_SESSION['sess_price'][$i];
            $temp_num[] = $_SESSION['sess_num'][$i];
            $temp_special[] = $_SESSION['sess_special'][$i];
        }
    }
    $_SESSION['sess_id'] = $temp_id;
    $_SESSION['sess_name'] = $temp_name;
    $_SESSION['sess_price'] = $temp_price;
    $_SESSION['sess_num'] = $temp_num;
    $_SESSION['sess_special'] = $temp_special; // สร้าง Session ใหม่ชื่อ sess_special
    header('location:my-basket.php');
}

// คำนวณ หรือ ยืนยัน
if (!empty($_POST)) {
    for ($i = 0; $i < count($_SESSION['sess_id']); $i++) {
        // ตรวจสอบจำนวนต้องไม่เท่ากับ 0
        if ($_POST['prd_num'][$i] != 0) {
            $temp_id[] = $_SESSION['sess_id'][$i];
            $temp_name[] = $_SESSION['sess_name'][$i];
            $temp_price[] = $_SESSION['sess_price'][$i];
            $temp_num[] = $_POST['prd_num'][$i]; // array จากการกรอกจำนวน
            $temp_special[] = $_POST['prd_special'][$i];
        }
    }
    $_SESSION['sess_id'] = $temp_id;
    $_SESSION['sess_name'] = $temp_name;
    $_SESSION['sess_price'] = $temp_price;
    $_SESSION['sess_num'] = $temp_num;
    $_SESSION['sess_special'] = $temp_special; // สร้าง Session ใหม่ชื่อ sess_special

    if ($_POST['calculate']) {
        header('location:my-basket.php');
    } elseif ($_POST['complete']) {
        header('location:my-order.php?event=complete');
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
    <title>R2O | รถเข็น</title>
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
    <!-- Pricing section-->
    <section class="py-5">
        <div class="container px-2 my-2">
            <div class="col-12 mb-2"> <a class="btn btn-primary" href="foods.php"><i class="fas fa-utensils"></i> เลือกซื้อเพิ่ม</a>
            </div>
            <form action="" method="post">
                <div class="card mb-5">
                    <h5 class="card-header bg-danger text-light text-center"><i class="fas fa-shopping-cart"></i> รถเข็น</h5>
                    <div class="card-body">
                        <?php if (isset($_SESSION['sess_id'])) { ?>
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
                                            <th class="border-0">ตัวจัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_SESSION['sess_id'])) {
                                            for ($i = 0; $i < count($_SESSION['sess_id']); $i++) {
                                                $total_unit = $_SESSION['sess_num'][$i] * $_SESSION['sess_price'][$i];
                                                $total = $total + $total_unit;
                                                $prd_id = $_SESSION['sess_id'][$i];
                                                $sql_img = " SELECT image_name FROM foods WHERE id = '$prd_id' ";
                                                $result_img = mysqli_query($conn, $sql_img);
                                                $rs_img = mysqli_fetch_assoc($result_img);
                                        ?>
                                                <tr style="line-height: 80px;">
                                                    <td class="border-0"><img class="rounded" src="images/food/<?= $rs_img['image_name'] ?>" alt="<?= $_SESSION['sess_name'][$i] ?>" width="50px" height="50px"></td>
                                                    <td class="border-0"><?= $_SESSION['sess_name'][$i] ?></td>
                                                    <td class="border-0"><input class="form-control text-center" type="number" name="prd_num[]" id="prd_num" value="<?= $_SESSION['sess_num'][$i] ?>" style="width: 5rem; margin-top:1.2rem"></td>
                                                    <td class="border-0"><?= number_format($_SESSION['sess_price'][$i]) ?></td>
                                                    <td class="border-0"><?= number_format($_SESSION['sess_num'][$i] * $_SESSION['sess_price'][$i]) ?></td>
                                                    <td class="border-0"><textarea class="form-control" name="prd_special[]" id="prd_spacail"><?= $_SESSION['sess_special'][$i] ?></textarea></td>
                                                    <td class="border-0"><a class="btn btn-sm btn-danger" href="my-basket.php?del_id=<?= $_SESSION['sess_id'][$i] ?>"><i class="far fa-trash-alt"></i></a></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                        <tr>
                                            <td class="border-0">&nbsp;</td>
                                            <td class="border-0">&nbsp;</td>
                                            <td class="border-0">&nbsp;</td>
                                            <td class="border-0"><strong>รวมทั้งหมด</strong></td>
                                            <td class="border-0">฿<?= number_format($total) ?></td>
                                            <td class="border-0">&nbsp;</td>
                                            <td class="border-0">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-warning text-center"><i class="far fa-thumbs-up"></i> เลือกเมนูอาหารโดนใจใส่รถเข็นได้เลย <br> <a class="btn btn-primary" href="foods.php"><i class="fas fa-utensils"></i> Order Now</a></div>
                        <?php } ?>
                    </div>
                    <hr>
                    <?php if (isset($_SESSION['sess_id'])) { ?>
                        <div class="card-food text-center mb-3">
                            <div class="row p-3">
                                <div class="col-lg-6 col-md-12 d-grid mb-1"><button type="submit" name="calculate" value="calculate" class="btn btn-primary"><i class="fas fa-calculator"></i> คำนวณ</button></div>
                                <div class="col-lg-6 col-md-12 d-grid mb-1"><button type="submit" name="complete" value="complete" class="btn btn-success"><i class="fas fa-shopping-cart"></i> ยืนยันสั่งซื้อ</button></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </section>
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dist/js/scripts.js"></script>
</body>

</html>