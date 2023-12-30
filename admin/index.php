<?php
// Session start and Connect database
include('../config/constants.php');
// function php
include('../config/function.php');
/*ดรวจสอบ sesion user_admin ไม่เท่ากับค่าว่าง และ status_login มีค่าเท่ากับ ture (1) 
สามารถ login เข้าสู่ระบบได้อย่างถูกต้อง ไม่เข้าเงื่อนไขจะส่งกลับไปหน้า login.php */
if ($_SESSION['user_admin'] != "" && $_SESSION['status_login'] === true) {
} else {
  header('location:login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>READY2Order | Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <!-- แจ้งเตือน Order ใหม่รอยืนยัน -->
        <?php
        // join 3 table customer,orders,order_address
        $sql_notify = " SELECT
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
        ORDER BY order_status_detail.order_status_time DESC ";
        $result_notify = mysqli_query($conn, $sql_notify);
        $num_notify = mysqli_num_rows($result_notify);
        ?>
        <?php if ($num_notify > 0) { ?>

          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="<?= number_format($no) ?>">
              <i class="far fa-bell"></i>
              <span class="badge badge-success navbar-badge"><?= number_format($num_notify) ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header"><?= number_format($num_notify) ?> ออเดอร์ใหม่</span>

              <?php while ($rs_notify = mysqli_fetch_assoc($result_notify)) { ?>
                <div class="dropdown-divider"></div>
                <a href="index.php?mn=order&file=order_detail&view_id=<?= $rs_notify['order_number'] ?>" class="dropdown-item" title="<?= str_time_diff($rs_notify['order_date']) ?> <?= DateThaiFull($rs_notify['order_date']) ?>">
                  <i class="fas fa-file mr-2"></i> #<?= $rs_notify['order_number'] ?>
                  <span class="float-right text-muted text-sm">จาก <?= $rs_notify['firstname'] ?></span>
                </a>
              <?php } ?>

              <div class="dropdown-divider"></div>
              <a href="index.php?mn=order&file=order_waiting" class="dropdown-item dropdown-footer">ออเดอร์ใหม่ทั้งหมด</a>
            </div>
          </li>

        <?php } else { ?>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-success navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">ยังไม่มีออเดอร์ใหม่</span>
            </div>
          </li>
        <?php } ?>


        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php" role="button">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../../index3.html" class="brand-link">
        <i class="fas fa-store fa-lg brand-image pt-1"></i>
        <span class="brand-text font-weight-light">READY2Order</span>
      </a>

      <!-- Sidebar -->
      <!-- นำเข้า sidebar เมนูด้านซ้ายจาก floder layout -->
      <?php include('layout/sidebar-menu.php'); ?>
      <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <!-- นำเข้าหัวข้อ -->
            <?php include('content_topic.php'); ?>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- require file admin -->
        <?php require('file_request.php'); ?>
        <!-- /.require file admin -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0-rc
      </div>
      <strong>Copyright &copy; 2021 READY2Order Restaurant. Developed By - <a href="https://patioaom.wixsite.com/kiattiphongporfolio" target="_blank">Kiattiphong Srangsut</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->
  <script>
    $('#image_name').on('change', function() {
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
    })
  </script>
</body>

</html>