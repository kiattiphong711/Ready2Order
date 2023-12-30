<?php

if (isset($_POST['submit'])) {
    //echo "click";
    //1. Get all the values from our form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //2.Updating New image if selected
    //Check whether the image is selected or not
    if (!empty($_FILES['image']['name'])) {
        //get the image details
        $image_name = $_FILES['image']['name'];

        //check whether the image is available or not
        if ($image_name != "") {
            //image Available
            //1. Upload the new image

            //Auto Rename our image
            //Get the extension of our image (jpg, png, gif, etc) e.g. "food_sogood.jpg"
            $tmp = explode('.', $image_name);
            $ext = end($tmp);

            //Rename The image
            $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; // eg. Food_Category_000.jpg


            $source_path = $_FILES['image']['tmp_name'];

            $destination_path = "../images/category/" . $image_name;

            //Finally Upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            //Check whether the image is uploaded or not
            //And if the image is not uploaded then we will stop the process and redirect with error message
            if ($upload == false) {
                //set message
                $msg = "<div class='error'>อัปโหลดรูปภาพล้มเหลว</div>";
                //Redirect to add Add category Page
                header('location:index.php?mn=category&file=category_edit&id_edit=<?=$id?>');
                //stop the Process
                die();
            }

            // 2. Remove the current image
            if ($current_image != "") {
                $remove_path = "../images/category/" . $current_image;

                $remove = unlink($remove_path);

                //check whether the image is removed or not
                //if failed to remove then display message and stop the process
                if ($remove == false) {
                    //failed to remove 
                    $msg = "<div class='alert alert-danger'>การลบรูปภาพล้มเหลว</div>";
                    header('location:index.php?mn=category&file=category_edit&id_edit=<?=$id?>');
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    //3. Update the database
    $sql2 = "UPDATE category SET
        title = '$title',
        image_name = '$image_name',
        featured = '$featured',
        active = '$active'
        WHERE id=$id
    ";

    //Execute the Query

    $res2 = mysqli_query($conn, $sql2);

    //4. Redirect to Manage Category with Message
    //Check whether executed or not

    if ($res2 == true) {
        //category Updated
        $msg = "<div class='alert alert-success'>แก้ไขข้อมูลสำเร็จ</div>";
        header('location:index.php?mn=category&file=category_list');
    } else {
        //failed to update
        $msg = "<div class='alert alert-danger'>แก้ไขข้อมูลล้มเหลว</div>";
        header('location:index.php?mn=category&file=category_edit&id_edit=<?=$id?>');
    }
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?= $msg ?>
            <!-- general form elements -->
            <?php
            $edit_id = $_GET['edit_id'];
            $sql_edit = "SELECT * FROM category WHERE id = '$edit_id'";
            $result_edit = mysqli_query($conn, $sql_edit);
            $rs_edit = mysqli_fetch_assoc($result_edit);
            ?>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">แก้ไขประเภทอาหาร</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">ชื่อประเภทอาหาร</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="ชื่อประเภท" value="<?= $rs_edit['title'] ?>">
                        </div>
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
                            <?php if ($rs_edit['image_name'] != "") { ?>
                                <img src="../images/category/<?= $rs_edit['image_name'] ?>" alt="" class="img-fluid mt-1">
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <?php
                            if ($rs_edit['featured'] == "YES") {
                                $fy_check = "checked";
                            }
                            if ($rs_edit['featured'] == "NO") {
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
                            if ($rs_edit['active'] == "YES") {
                                $ay_check = "checked";
                            }
                            if ($rs_edit['active'] == "NO") {
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
                        <input type="hidden" name="current_image" value="<?= $rs_edit['image_name'] ?>">
                        <input type="hidden" name="id" value="<?= $rs_edit['id'] ?>">
                        <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>