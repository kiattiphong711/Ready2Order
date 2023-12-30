<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image text-white">
            <i class="fas fa-user-circle fa-2x"></i>
        </div>
        <div class="info">
            <!-- ชื่อแอดมิน Username Admin -->
            <a href="#" class="d-block"><?= $_SESSION['user_admin'] ?></a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="index.php?mn=dashboard&file=dashboard_list" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        ภาพรวม
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?mn=category&file=category_list" class="nav-link">
                    <i class="nav-icon fas fa-list-ul"></i>
                    <p>
                        ประเภทอาหาร
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?mn=food&file=food_list" class="nav-link">
                    <i class="nav-icon fas fa-utensils"></i>
                    <p>
                        อาหาร
                    </p>
                </a>
            </li>
            <li class="nav-item menu-is-opening menu-open">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        ออเดอร์
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: block;">
                    <li class="nav-item">
                        <a href="index.php?mn=order&file=order_waiting" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รอการยืนยันออเดอร์</p>
                            <?php if ($num_notify > 0) { ?>
                                <span class="badge badge-success right"><?= number_format($num_notify) ?></span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=order&file=order_confirm" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รับออเดอร์</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=order&file=order_working" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>กำลังทำอาหาร</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=order&file=order_finish" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>อาหารของคุณเสร็จแล้ว</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=order&file=order_cancel" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ยกเลิกออเดอร์แล้ว</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=order&file=order_list" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ออเดอร์ทั้งหมด</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item menu-is-opening menu-open">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-file-alt"></i>
                    <p>
                        รายงาน
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: block;">
                    <li class="nav-item">
                        <a href="index.php?mn=report&file=report_best_day" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ขายดีประจำวัน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=report&file=report_best_month" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ขายดีประจำเดือน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=report&file=report_list" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ยอดขายรายวัน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=report&file=report_month" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ยอดขายรายเดือน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?mn=report&file=report_year" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ยอดขายรายปี</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="index.php?mn=customer&file=customer_list" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p>
                        ผู้ใช้งาน
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?mn=system&file=system_list" class="nav-link">
                    <i class="nav-icon fas fa-user-lock"></i>
                    <p>
                        ผู้ดูแลระบบ
                    </p>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>