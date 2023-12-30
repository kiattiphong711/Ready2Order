<?php
//Check whether the submit button is Clicked or Not
if (isset($_POST['submit'])) {
    //echo "Clicked";

    //1. Get the value from Category form
    $title = $_POST['title'];

    //For Radio input, need to check whether the button is selected or not
    if (isset($_POST['featured'])) {
        //Get the value from form
        $featured = $_POST['featured'];
    } else {
        //set the Default Value
        $featured = "No";
    }

    if (isset($_POST['active'])) {
        $active = $_POST['active'];
    } else {
        $active = "No";
    }

    //Check whether the image is selected or not and set the value for image name accoridingly
    //print_r($_FILES['image']);

    //die(); // BREAK THE CODE HERE

    if (isset($_FILES['image']['name'])) {
        //Upload The image
        //To upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        //Upload the image only if image is selected
        if ($image_name != "") {
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
                $msg = "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์ </div>";
                //stop the Process
                die();
            }
        }
    } else {
        //Dont upload Image and set the Image_name value as blank
        $image_name = "";
    }

    //2. Create SQL to Insert Category into database
    $sql = "INSERT INTO category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

    //3. Execute the query and Save in database
    $res = mysqli_query($conn, $sql);

    //4. Check whether the query executed or not and data added or not
    if ($res == true) {
        //Query Executed and Category Added
        $msg = "<div class='alert alert-success'>บันทึกข้อมูลสำเร็จ</div>";
        //Redirect to Manage Category Page
        header('location:index.php?mn=category&file=category_list');
    } else {
        //FAiles to add Category
        $msg = "<div class='alert alert-danger'>บันทึกข้อมูลล้มเหลว</div>";
    }
}
?>
<div class="col-md-12">
    <?= $msg ?>
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">เพิ่มประเภทอาหาร</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="title">ชื่อประเภทอาหาร</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="ชื่อประเภท">
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
                </div>
                <div class="form-group">
                    <label for="featured">Featured</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="featured" name="featured" value="YES">
                        <label for="featured" class="custom-control-label">YES</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="featured1" name="featured" value="NO">
                        <label for="featured1" class="custom-control-label">NO</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Active</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="active" value="YES">
                        <label for="customRadio1" class="custom-control-label">YES</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="active" value="NO">
                        <label for="customRadio2" class="custom-control-label">NO</label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>