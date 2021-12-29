<?php 
include("include/header.php");

$id = $_GET['id'];
$display_sql = mysqli_query($conn, "SELECT * FROM tbl_voucher_type WHERE typeID = '$id'");
$rows = mysqli_fetch_assoc($display_sql);

if(isset($_POST['update'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $value = $_POST['value'];
    $cost = $_POST['cost'];

    $update_sql = "UPDATE tbl_voucher_type SET typeName = '$name', typeDesc = '$desc', voucherValue = '$value', voucherCost = '$cost' WHERE typeID = '$id'";
    if(mysqli_query($conn, $update_sql))
    {
        $count = mysqli_num_rows(mysqli_query($conn, "SELECT logID FROM tbl_activity_log"));
        $not_inserted = true;
        for($i = 0; $i <= $count; $i++) {
            $temp = "log_".$i;
            $res = mysqli_query($conn, "SELECT logID FROM tbl_activity_log WHERE logID ='$temp'");
            if(!$res && $not_inserted) {
                $not_inserted = false;
            }
        }
        $logID = $temp;

        $logContent = "Updated Voucher Type ".$id." with the following changes:
        Type Name: ".$rows['typeName']." -> ".$name.",
        Type Description: ".$rows['typeDesc']." -> ".$desc.",
        Voucher Value: ".$rows['voucherValue']." -> ".$value.",
        Voucher Cost: ".$rows['voucherCost']." -> ".$cost."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Update Product Category', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Update Successful')</script>";
            echo "<script>window.open('manage_voucher.php','_self')</script>";
        }
    }else{
        echo "<script>alert('Update Failed')</script>";
        echo "<script>window.open('manage_voucher.php','_self')</script>";
    }
}

?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Voucher Management</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">Voucher ID: <?php echo $rows['typeID']?></p>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="name">
                                                        <strong>Voucher Type Name</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="name" value="<?php echo $rows['typeName']?>" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="desc">
                                                        <strong>Description</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="desc" value="<?php echo $rows['typeDesc']?>" name="desc" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Cost">
                                                        <strong>Value</strong>
                                                    </label>
                                                    <input type="number" class="form-control" id="value" value="<?php echo $rows['voucherValue']?>" name="value" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Cost">
                                                        <strong>Cost</strong>
                                                    </label>
                                                    <input type="number" class="form-control" id="cost" value="<?php echo $rows['voucherCost']?>" name="cost" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class ="row">
                                            <div class="col-lg-2">
                                                <div class="col-mb-2">
                                                    <button class="btn btn-primary btn-sm" type="submit" name="update">Update Voucher Type</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <?php 
            include("include/footer.php");
            ?>
</body>

</html>