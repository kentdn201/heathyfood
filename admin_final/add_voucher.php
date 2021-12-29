<?php 
include("include/header.php");

if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $value = $_POST['value'];
    $cost = $_POST['cost'];

    $count = mysqli_num_rows(mysqli_query($conn, "SELECT typeID FROM tbl_voucher_type"));
    $not_inserted = true;
    for($i = 0; $i <= $count; $i++) {
        $temp = "type_".$i;
        $res = mysqli_query($conn, "SELECT typeID FROM tbl_voucher_type WHERE typeID = '$temp'");
        if(!$res && $not_inserted) {
            $not_inserted = false;
        }
    }
    $id = $temp;

    $add_sql = mysqli_query($conn, "INSERT INTO tbl_voucher_type(typeID, typeName, typeDesc, voucherValue, voucherCost)
                                    VALUES ('$id', '$name', '$desc', '$cost')");
    if($add_sql) {
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

        $logContent = "Added Voucher Type ".$id." with the following identifications:
            Voucher Name: ".$name.",
            Voucher Description: ".$cost.",
            Voucher Value: ".$value.",
            Voucher Cost: ".$cost."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Add Voucher Type', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Add Successful')</script>";
            echo "<script>window.open('manage_voucher.php','_self')</script>";
        }
    }
    else {
        echo "<script>alert('Add Failed')</script>";
        echo "<script>window.open('manage_voucher.php','_self')</script>";
    }
}
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Add New Voucher Type</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">Voucher Type Information</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="name">
                                                        <strong>Voucher Type Name</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="name" placeholder="Enter Voucher Type Name" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label class="form-label" for="desc">
                                                        <strong>Description</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="desc" placeholder="Enter Voucher Type Description" name="desc" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Cost">
                                                        <strong>Value</strong>
                                                    </label>
                                                    <input type="number" class="form-control" id="cost" placeholder="Enter Voucher Value" name="value" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Cost">
                                                        <strong>Cost</strong>
                                                    </label>
                                                    <input type="number" class="form-control" id="cost" placeholder="Enter Trade Cost" name="cost" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class ="row">
                                            <div class="col-lg-2">
                                                <div class="col-mb-2">
                                                    <button class="btn btn-primary btn-sm" type="submit" name="add">Add Voucher Type</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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