<div class="container-fluid">
    <p>
        <a href="index.php?mn=category&file=category_add" class="btn btn-primary">เพิ่มข้อมูล</a>
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ประเภทอาหาร</th>
                    <th>รูปภาพ</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>ตัวจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php $sql_cate = " SELECT * FROM category ORDER BY id ASC";
                $result_cate = mysqli_query($conn, $sql_cate);
                while ($rs_cate = mysqli_fetch_assoc($result_cate)) {
                ?>
                    <tr>
                        <td><?= $rs_cate['id'] ?></td>
                        <td><?= $rs_cate['title'] ?></td>
                        <td><img src="../images/category/<?= $rs_cate['image_name'] ?>" width="80px" class="rounded" alt="<?= $rs_cate['title'] ?>"></td>
                        <td><?= $rs_cate['featured'] ?></td>
                        <td><?= $rs_cate['active'] ?></td>
                        <td>
                            <a href="index.php?mn=category&file=category_detail&view_id=<?= $rs_cate['id'] ?>" class="btn btn-info mb-1"><i class="fas fa-binoculars"></i></a>
                            <a href="index.php?mn=category&file=category_edit&edit_id=<?= $rs_cate['id'] ?>" class="btn btn-warning mb-1"><i class="fas fa-edit"></i></a>
                            <a href="index.php?mn=category&file=category_delete&delete_id=<?= $rs_cate['id'] ?>" class="btn btn-danger mb-1"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>