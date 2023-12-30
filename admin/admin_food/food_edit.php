<?php

if (isset($_POST['submit'])) {
    //echo "click";
    //1. Get all the details from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];

    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //2. Upload the image if selected
    if (!empty($_FILES['image']['name'])) {
        //update button clicked
        $image_name = $_FILES['image']['name']; //new image name
        if ($image_name != "") {
            //image is avilable
            //Rename the image
            $tmp = explode('.', $image_name);
            $ext = end($tmp);

            $image_name = "Food-" . rand(0000, 9999) . '.' . $ext; //rename

            //get source Path and Destination Path
            $src_path = $_FILES['image']['tmp_name']; // Source Path
            $dest_path = "../images/food/" . $image_name; //Destination Path

            //Upload the image
            $upload = move_uploaded_file($src_path, $dest_path);

            //check whether the image
            if ($upload == false) {
                //Failed to upload
                $msg = "<div class='alert alert-danger'>อัปโหลดล้มเหลว</div>";
                die();
            }
            //3. Remove the image if new image is uploaded and current image exists

            if ($current_image != "") {
                $remove_path = "../images/food/" . $current_image;

                $remove = unlink($remove_path);

                if ($remove == false) {
                    $msg = "<div class='alert alert-danger'>การลบภาพล้มเหลว</div>";
                    die();
                }
            }
        }
    } else {
        $image_name = $current_image;
    }



    //4. Update the food in database 

    $sql3 = "UPDATE foods SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true) {
        $msg = "<div class='alert alert-success'>บันทึกสำเร็จ</div>";
        header('location:index.php?mn=food&file=food_list');
    } else {
        $msg = "<div class='alert alert-danger'>แก้ไขล้มเหลว</div>";
    }
}

?>
<div class="col-md-12">
    <?= $msg ?>
    <!-- general form elements -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">แก้ไขเมนูอาหาร</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <?php
        $edit_id = $_GET['edit_id'];
        $sql_food = "SELECT * FROM foods WHERE id = '$edit_id' ";
        $result_food = mysqli_query($conn, $sql_food);
        $rs_food = mysqli_fetch_assoc($result_food);
        ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="image_name">รูปภาพ</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image_name" name="image" accept="image/*">
                            <label class="custom-file-label" for="image_name">เลือกไฟล์</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="nav-icon far fa-image"></i></span>
                        </div>
                    </div>
                    <?php if ($rs_food['image_name'] != "") { ?>
                        <img src="../images/food/<?= $rs_food['image_name'] ?>" alt="" class="img-fluid mt-1">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="title">ประเภทอาหาร</label>
                    <select name="category" id="category" class="form-control">
                        <option disabled>เลือกประเภทอาหาร</option>
                        <?php $sql_cate = "SELECT * FROM category ORDER BY id ASC";
                        $result_cate = mysqli_query($conn, $sql_cate);
                        while ($rs_cate = mysqli_fetch_assoc($result_cate)) {
                            if ($rs_cate['id'] == $rs_food['category_id']) {
                        ?>
                                <option value="<?= $rs_cate['id'] ?>" selected><?= $rs_cate['title'] ?></option>

                            <?php } else { ?>
                                <option value="<?= $rs_cate['id'] ?>"><?= $rs_cate['title'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">ชื่ออาหาร</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="ชื่ออาหาร" value="<?= $rs_food['title'] ?>">
                </div>
                <div class="form-group">
                    <label for="price">ราคา</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="ราคา" value="<?= $rs_food['price'] ?>">
                </div>
                <div class="form-group">
                    <label for="description">รายละเอียด</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10" placeholder="รายละเอียด"><?= $rs_food['description'] ?></textarea>
                </div>
                <div class="form-group">
                    <?php
                    if ($rs_food['featured'] == "YES") {
                        $fy_check = "checked";
                    }
                    if ($rs_food['featured'] == "NO") {
                        $fn_check = "checked";
                    }
                    ?>
                    <label for="featured">Featured</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="featured" name="featured" value="YES" <?= $fy_check ?>>
                        <label for="featured" class="custom-control-label">YES</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="featured1" name="featured" value="NO" <?= $fn_check ?>>
                        <label for="featured1" class="custom-control-label">NO</label>
                    </div>
                </div>
                <div class="form-group">
                    <?php
                    if ($rs_food['active'] == "YES") {
                        $ay_check = "checked";
                    }
                    if ($rs_food['active'] == "NO") {
                        $an_check = "checked";
                    }
                    ?>
                    <label for="exampleInputFile">Active</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="active" value="YES" <?= $ay_check ?>>
                        <label for="customRadio1" class="custom-control-label">YES</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="active" value="NO" <?= $an_check ?>>
                        <label for="customRadio2" class="custom-control-label">NO</label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <input type="hidden" name="current_image" value="<?= $rs_food['image_name'] ?>">
                <input type="hidden" name="id" value="<?= $rs_food['id'] ?>">
                <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>