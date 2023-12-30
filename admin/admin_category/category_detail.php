<?php $view_id = $_GET['view_id'];
$sql = "SELECT * FROM category WHERE id = '$view_id'";
$result = mysqli_query($conn, $sql);
$rs = mysqli_fetch_assoc($result);
?>
<div class="col-md-8">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title"><?= $rs['title'] ?></h3>
        </div>
        <img src="../images/category/<?= $rs['image_name'] ?>" class="card-img-top img-fluid" alt="<?= $rs['title'] ?>">
        <div class="card-body">
            <ul class="list-group list-group-flush text-center">
                <li class="list-group-item"><strong>Featured</strong> : <?= $rs['featured'] ?></li>
                <li class="list-group-item"><strong>Active</strong> : <?= $rs['active'] ?></li>
            </ul>
        </div>
    </div>
</div>