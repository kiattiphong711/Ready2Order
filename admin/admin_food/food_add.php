<?php
//Check whether the button is clicked or not
if (isset($_POST['submit'])) {
    //add the food in database
    //1. Get data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    //Check whether radio button for fretured and active are checked
    if (isset($_POST['featured'])) {
        $featured = $_POST['featured'];
    } else {
        $featured = "No"; //Setting the Default Value
    }

    if (isset($_POST['active'])) {
        $active = $_POST['active'];
    } else {
        $active = "No"; //Setting the Default Value
    }



    //2. Upload the Image if selected
    //Check whether the select image is clicked or not and upload the image only
    if (isset($_FILES['image']['name'])) {
        //Get the details of the selected image
        $image_name = $_FILES['image']['name'];

        //check whether the image is selected or not and upload image only if selected
        if ($image_name != "") {
            //Image is Selected
            //A. rename the image
            //Get the extension of selected image (jpg etc.)
            $tmp = explode('.', $image_name);
            $ext = end($tmp);

            //Create New name for image
            $image_name = "Food-" . rand(0000, 9999) . "." . $ext; //New Image Name Ex . Food-000.jpg

            //B. Upload the Image
            //Get the Scr path and Destinaton path

            //Source path is the current Location of the image
            $src = $_FILES['image']['tmp_name'];

            //Destination Path for the image to be upload
            $dst = "../images/food/" . $image_name;

            //Finally upload
            $upload = move_uploaded_file($src, $dst);

            //Check whether image uploaded of not
            if ($upload == false) {
                //Failed uploade
                //Redirect to add food page
                $msg = "<div class='alert alert-danger'>อัปโหลดล้มเหลว</div>";
                die(); // stop process
            }
        }
    } else {
        $image_name = ""; //Setting the default
    }


    //3. Insert Into Database
    //Create a SQL Query to save
    //For Numerical we do not need to paa value inside quotes '' But for string value it is compulsory to add quotes ''
    $sql2 = "INSERT INTO foods SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

    //Execute the query
    $res2 = mysqli_query($conn, $sql2);
    //Check whether data inserted or not
    //4. Redirect with Message to manage food page
    if ($res2 == true) {
        //Data inserted Successfully
        //Query Executed and Category Added
        $msg = "<div class='alert alert-success'>บันทึกสำเร็จ</div>";
        //Redirect to Manage Category Page
        header('location:index.php?mn=food&file=food_list');
    } else {
        //Failed to Insert Data
        $msg = "<div class='alert alert-danger'>บันทึกล้มเหลว</div>";
    }
}
?>
<div class="col-md-12">
    <?= $msg ?>
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">เพิ่มเมนูอาหาร</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
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
                </div>
                <div class="form-group">
                    <label for="title">ประเภทอาหาร</label>
                    <select name="category" id="category" class="form-control">
                        <option disabled>เลือกประเภทอาหาร</option>
                        <?php $sql_cate = "SELECT * FROM category ORDER BY id ASC";
                        $result_cate = mysqli_query($conn, $sql_cate);
                        while ($rs_cate = mysqli_fetch_assoc($result_cate)) {
                        ?>
                            <option value="<?= $rs_cate['id'] ?>"><?= $rs_cate['title'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">ชื่ออาหาร</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="ชื่ออาหาร">
                </div>
                <div class="form-group">
                    <label for="price">ราคา</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="ราคา">
                </div>
                <div class="form-group">
                    <label for="description">รายละเอียด</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10" placeholder="รายละเอียด"></textarea>
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