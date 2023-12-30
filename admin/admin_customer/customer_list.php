<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-striped table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>อีเมล</th>
                    <th>ตัวจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php $sql_customer = " SELECT * FROM customer ORDER BY id ASC";
                $result_customer = mysqli_query($conn, $sql_customer);
                $no = 1;
                while ($rs_customer = mysqli_fetch_assoc($result_customer)) {
                ?>
                    <tr>
                        <td><?= $rs_customer['id'] ?></td>
                        <td><?= $rs_customer['firstname'] ?></td>
                        <td><?= $rs_customer['lastname'] ?></td>
                        <td><?= $rs_customer['mobilenumber'] ?></td>
                        <td><?= $rs_customer['email'] ?></td>
                        <td>
                            <a href="index.php?mn=customer&file=customer_detail&view_id=<?= $rs_customer['id'] ?>" class="btn btn-info mb-1"><i class="fas fa-binoculars"></i></a>
                            <a href="index.php?mn=customer&file=customer_edit&edit_id=<?= $rs_customer['id'] ?>" class="btn btn-warning mb-1"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
        </table>
    </div>
</div>