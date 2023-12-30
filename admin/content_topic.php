<div class="col-sm-6">
    <h1><?= topicName($_GET['mn']) ?></h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> หน้าหลัก</a></li>
        <?php
        // ตรวจสอบไฟล์ที่นำเข้ามีอยู่จริงไหม ถ้าไม่มีไม่แสดงผล
        $file = 'admin_' . $_GET['mn'] . '/' . $_GET['file'] . '.php';
        if (file_exists($file) or ($_GET['mn'] == "" && $_GET['mn'] == "")) {
            echo topicName2($_GET['mn']);
            echo topicSecond($_GET['file']);
        }
        ?>
    </ol>
</div>