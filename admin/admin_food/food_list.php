<div class="container-fluid">
    <p>
        <a href="index.php?mn=food&file=food_add" class="btn btn-primary">เพิ่มข้อมูล</a>
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ประเภทอาหาร</th>
                    <th>ชื่ออาหาร</th>
                    <th>ราคา</th>
                    <th>รูปภาพ</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>ตัวจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <!-- select inner join 2 table foods and category  -->
                <?php $sql_food = " SELECT foods.id,foods.title,foods.description,foods.price,foods.image_name,foods.featured,foods.active,category.title AS 'category_name' FROM foods INNER JOIN category ON foods.category_id = category.id ORDER BY foods.id ASC,foods.category_id ASC";
                $result_food = mysqli_query($conn, $sql_food);
                while ($rs_food = mysqli_fetch_assoc($result_food)) {
                ?>
                    <tr>
                        <td><?= $rs_food['id'] ?></td>
                        <td><?= $rs_food['category_name'] ?></td>
                        <td><?= $rs_food['title'] ?></td>
                        <td>฿<?= number_format($rs_food['price'], 2) ?></td>
                        <td><img src="../images/food/<?= $rs_food['image_name'] ?>" width="80px" class="rounded" alt="<?= $rs_food['title'] ?>"></td>
                        <td><?= $rs_food['featured'] ?></td>
                        <td><?= $rs_food['active'] ?></td>
                        <td>
                            <a href="index.php?mn=food&file=food_detail&view_id=<?= $rs_food['id'] ?>" class="btn btn-info mb-1"><i class="fas fa-binoculars"></i></a>
                            <a href="index.php?mn=food&file=food_edit&edit_id=<?= $rs_food['id'] ?>" class="btn btn-warning mb-1"><i class="fas fa-edit"></i></a>
                            <a href="index.php?mn=food&file=food_delete&delete_id=<?= $rs_food['id'] ?>" class="btn btn-danger mb-1"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>