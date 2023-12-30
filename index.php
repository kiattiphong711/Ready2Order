<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | หน้าหลัก</title>
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
                                <input type="search" name="search_foods" class="form-control" placeholder="ค้นหาเมนูอาหาร..." aria-label="ค้นหาเมนูอาหาร..." aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i> ค้นหา</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ตัวค้นหาสิ้นสุด -->
    <!-- Features section-->
    <section class="py-5 border-bottom" id="features">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">รายการอาหาร</h2>
            </div>
            <div class="row gx-5">
                <?php
                $sql_category = " SELECT * FROM category WHERE featured = 'YES' AND active = 'YES' ORDER BY id ASC LIMIT 0,3";
                $result_category = mysqli_query($conn, $sql_category);
                while ($rs_category = mysqli_fetch_assoc($result_category)) {
                ?>
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="container-ready2">
                            <a href="category-foods.php?category_id=<?= $rs_category['id'] ?>"><img src="./images/category/<?= $rs_category['image_name'] ?>" class="card-img-top boder-0 rounded" alt="<?= $rs_category['title'] ?>"></a>
                            <div class="ready2-centered"><?= $rs_category['title'] ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Pricing section-->
    <section class="bg-foods py-5 border-bottom">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">เมนูอาหาร</h2>
            </div>
            <div class="row gx-5 justify-content-left">

                <!-- Pricing card free-->
                <?php
                $sql_foods = " SELECT * FROM foods WHERE featured = 'YES' AND active = 'YES' ORDER BY id ASC LIMIT 0,6";
                $result_foods = mysqli_query($conn, $sql_foods);
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
                <?php } ?>

            </div>
            <div class="col-lg-12 col-xl-12 text-center menu-readyfoods"><a href="foods.php">ดูเมนูทั้งหมด</a></div>
        </div>
    </section>
    <?php include('layout/footer.php'); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="dist/js/scripts.js"></script>
</body>

</html>