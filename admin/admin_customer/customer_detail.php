<?php
$view_id = $_GET['view_id'];
$sql = " SELECT * FROM customer WHERE id = '$view_id' ";
$result = mysqli_query($conn, $sql);
$rs = mysqli_fetch_assoc($result);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="far fa-user-circle fa-4x"></i>
                    </div>
                    <h3 class="profile-username text-center"><?= $rs['firstname'] ?>&nbsp;&nbsp;<?= $rs['lastname'] ?></h3>

                    <p class="text-muted text-center"><?= $rs['mobilenumber'] ?></p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>ออเดอร์</b> <a class="float-right">22 ครั้ง</a>
                        </li>
                        <li class="list-group-item">
                            <b>ยกเลิก</b> <a class="float-right">2 ครั้ง</a>
                        </li>
                        <li class="list-group-item">
                            <b>ยอดซื้อ</b> <a class="float-right">1,287฿</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">รายละเอียดผู้ใช้งาน</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="firstname" class="col-sm-2 col-form-label">ชื่อ</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="firstname" value="<?= $rs['firstname'] ?>" readonly="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastname" class="col-sm-2 col-form-label">นามสกุล</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="lastname" value="<?= $rs['lastname'] ?>" readonly="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobilenumber" class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="mobilenumber" value="<?= $rs['mobilenumber'] ?>" readonly="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">อีเมล</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" value="<?= $rs['email'] ?>" readonly="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="regdate" class="col-sm-2 col-form-label">วันที่ลงทะเบียน</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="regdate" value="<?= DateThaiFull($rs['regdate']) ?>" readonly="true">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>
</div>