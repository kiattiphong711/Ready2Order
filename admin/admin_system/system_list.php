<div class="container-fluid">
    <?php if ($_GET['msg'] == "ban") { ?>
        <div class="alert alert-warning">ระบบไม่อนุญาตให้ลบไอดีหลัก</div>
    <?php } ?>
    <p>
        <a href="index.php?mn=system&file=system_add" class="btn btn-primary">เพิ่มข้อมูล</a>
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อแสดงในระบบ</th>
                    <th>Username</th>
                    <th>ตัวจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php $sql_system = " SELECT * FROM user_admin ORDER BY id ASC";
                $result_system = mysqli_query($conn, $sql_system);
                $no = 1;
                while ($rs_system = mysqli_fetch_assoc($result_system)) {
                ?>
                    <tr>
                        <td><?= $rs_system['id'] ?></td>
                        <td><?= $rs_system['full_name'] ?></td>
                        <td><?= $rs_system['username'] ?></td>
                        <td>
                            <a href="index.php?mn=system&file=system_change&change_id=<?= $rs_system['id'] ?>" class="btn btn-dark mb-1"><i class="fas fa-user-lock"></i></a>
                            <a href="index.php?mn=system&file=system_edit&edit_id=<?= $rs_system['id'] ?>" class="btn btn-warning mb-1"><i class="fas fa-edit"></i></a>
                            <!-- ป้องกันการลบไอดี 1 ทิ้งกรณีลบออกหมดจะไม่สามารถ login ได้ -->
                            <?php if ($no != 1) { ?>
                                <a href="index.php?mn=system&file=system_delete&delete_id=<?= $rs_system['id'] ?>" class="btn btn-danger mb-1"><i class="fas fa-trash-alt"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>