<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>R2O | รายการอาหาร</title>
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
    <!-- Features section-->
    <section class="py-5 border-bottom" id="features">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">รายการอาหาร</h2>
            </div>
            <div class="row gx-5">
                <?php
                $sql_category = " SELECT * FROM category WHERE active = 'YES' ORDER BY id ASC";
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