<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | เมนูอาหาร</title>
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
    <header class="bg-ready2orders py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center my-5">
                        <form action="food-search.php" method="get">
                            <div class="input-group input-group-lg mb-3">
                                <input type="search" name="search_foods" class="form-control" placeholder="ค้นหาเมนูอาหาร..." aria-label="ค้นหาเมนูอาหาร..." aria-describedby="button-addon2" required>
                                <button type="submit" class="btn btn-primary" id="button-addon2"><i class="fas fa-search"></i> ค้นหา</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ตัวค้นหาสิ้นสุด -->
    <!-- Pricing section-->
    <section class="bg-foods py-5 border-bottom">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">เมนูอาหาร</h2>
            </div>
            <div class="row gx-5 justify-content-left">

                <!-- Pricing card free-->
                <?php
                $sql_foods = " SELECT * FROM foods WHERE active='Yes' ORDER BY id ASC";
                $result_foods = mysqli_query($conn, $sql_foods);
                $num_foods = mysqli_num_rows($result_foods);
                if ($num_foods > 0) {
                    while ($rs_foods = mysqli_fetch_assoc($result_foods)) {
                ?>
                        <div class="col-lg-6 col-xl-6">
                            <!-- Testimonial 1-->
                            <div class="card mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0"><img class="rounded img-responsive" src="images/food/<?= $rs_foods['image_name'] ?>" alt="" width="94px" height="94px"></div>
                                        <div class="ms-4">
                                            <div class="mb-1"><strong><?= $rs_foods['title'] ?></strong></div>
                                            <div class="mb-1">฿<?= number_format($rs_foods['price'], 2) ?></div>
                                            <div class="small text-muted mb-2"><?= nl2br($rs_foods['description']) ?></div>
                                            <div class="mb-1"><a href="my-basket-add.php?id_prd=<?= $rs_foods['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-shopping-cart"></i> Order Now</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="col-lg-12 col-xl-12">
                        <div class="alert alert-danger text-center"><i class="fas fa-exclamation-circle"></i> ไม่มีเมนูอาหารให้บริการ</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
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