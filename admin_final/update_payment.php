<?php 
include("include/header.php");

$id = $_GET['id'];
$display_sql = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE paymentID = '$id'");
$rows = mysqli_fetch_assoc($display_sql);

if(isset($_POST['update'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];

    $update_sql = "UPDATE tbl_payment SET paymentName ='$name', paymentDesc = '$desc' WHERE paymentID = '$id'";
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

        $logContent = "Updated Payment Type ".$id." with the following changes:
        Payment Name: ".$rows['paymentName']." -> ".$name.",
        Payment Description: ".$rows['paymentDesc']." -> ".$desc."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Update Payment Type', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Update Successful')</script>";
            echo "<script>window.open('manage_payment.php','_self')</script>";
        }
    }else{
        echo "<script>alert('Update Failed')</script>";
        echo "<script>window.open('manage_payment.php','_self')</script>";
    }
}

?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Payment Management</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">Payment ID: <?php echo $rows['paymentID']?></p>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="name">
                                                        <strong>Payment Name</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="name" value="<?php echo $rows['paymentName']?>" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label class="form-label" for="desc">
                                                        <strong>Description</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="desc" value="<?php echo $rows['paymentDesc']?>" name="desc" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class ="row">
                                            <div class="col-lg-2">
                                                <div class="col-mb-2">
                                                    <button class="btn btn-primary btn-sm" type="submit" name="update">Confirm Update</button>
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