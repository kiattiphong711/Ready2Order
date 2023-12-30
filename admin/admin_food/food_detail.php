<?php $view_id = $_GET['view_id'];
// inner join 2 ตารางระหว่าง ตาราง foods กับ category
$sql = "SELECT category.title AS 'category_name',foods.title,foods.description,foods.price,foods.image_name,foods.featured,foods.active
        FROM foods INNER JOIN category ON foods.category_id = category.id 
        WHERE foods.id = '$view_id'";
$result = mysqli_query($conn, $sql);
$rs = mysqli_fetch_assoc($result);
?>
<div class="col-md-8">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title"><?= $rs['title'] ?></h3>
        </div>
        <img src="../images/food/<?= $rs['image_name'] ?>" class="card-img-top img-fluid" alt="<?= $rs['title'] ?>">
        <div class="card-body">
            <ul class="list-group list-group-flush text-left">
                <li class="list-group-item"><strong>ประเภทอาหาร</strong> : <?= $rs['category_name'] ?></li>
                <li class="list-group-item"><strong>ราคา</strong> : ฿<?= number_format($rs['price'], 2) ?></li>
                <li class="list-group-item"><strong>รายละเอียด</strong> : <?= $rs['description'] ?></li>
                <li class="list-group-item"><strong>Featured</strong> : <?= $rs['featured'] ?></li>
                <li class="list-group-item"><strong>Active</strong> : <?= $rs['active'] ?></li>
            </ul>
        </div>
    </div>
</div>