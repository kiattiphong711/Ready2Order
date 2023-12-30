<?php
include('config/constants.php');
// ถ้าไม่มีการ login ไม่สามารถเข้าสู่หน้านี้ได้
if ($_SESSION['mycustomer_id'] != "" && $_SESSION['mycustomer_status'] === true) {
} else {
    header('location:login.php');
    exit; // ออกการทำงานเมื่อใ้ช้ function exit
}
?>
<script language="javascript" type="text/javascript">
    function f2() {
        window.close();
    }

    function f3() {
        window.print();
    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบสั่งของ</title>
</head>

<body>
    <div style="margin-left:50px;">

        <table border="1" cellpadding="10" style="border-collapse: collapse; border-spacing:0; width: 100%; text-align: center;">
            <tr align="center">
                <th colspan="6">เลขออเดอร์ #<?= $_GET['oid'] ?></th>
            </tr>
            <tr>
                <th>#</th>
                <th>อาหาร </th>
                <th>เมนูอาหาร</th>
                <th>จำนวน</th>
                <th>ราคาต่อหน่วย</th>
                <th>รวม</th>
            </tr>
            <tr>
                <?php $sql_order2 = "SELECT * FROM orders WHERE order_number = " . $_GET['oid'] . " ORDER BY id ASC ";
                $result_order2 = mysqli_query($conn, $sql_order2);
                $no = 1;
                while ($rs_order2 = mysqli_fetch_assoc($result_order2)) {
                    $sql_img = " SELECT * FROM foods WHERE id = " . $rs_order2['food_id'];
                    $result_img = mysqli_query($conn, $sql_img);
                    $rs_foods = mysqli_fetch_assoc($result_img);
                    $sum_order = $rs_foods['price'] * $rs_order2['food_qty'];
                    $total_order = $total_order + $sum_order;
                ?>
                    <td><?= $no ?></td>
                    <td>
                        <img src="images/food/<?= $rs_foods['image_name'] ?>" width="60" height="40" alt="<?= $rs_foods['title'] ?>">
                    </td>
                    <td><?= $rs_foods['title'] ?></td>
                    <td><?= number_format($rs_order2['food_qty']) ?></td>
                    <td><?= number_format($rs_foods['price']) ?></td>
                    <td><?= number_format($sum_order) ?></td>
            </tr>
        <?php
                    $no++;
                } ?>
        <tr>
            <th colspan="5" style="text-align:center">รวมทั้งหมด </th>
            <td><?= number_format($total_order) ?> บาท</td>
        </tr>
        </table>

        <p>
            <input name="Submit2" type="submit" class="txtbox4" value="ปิด" onClick="return f2();" style="cursor: pointer;" /> <input name="Submit2" type="submit" class="txtbox4" value="พิมพ์" onClick="return f3();" style="cursor: pointer;" />
        </p>
    </div>
</body>

</html>