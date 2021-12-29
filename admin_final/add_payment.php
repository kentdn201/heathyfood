<?php 
include("include/header.php");

if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];

    $count = mysqli_num_rows(mysqli_query($conn, "SELECT paymentID FROM tbl_payment"));
    $not_inserted = true;
    for($i = 0; $i <= $count; $i++) {
        $temp = "payment_".$i;
        $res = mysqli_query($conn, "SELECT paymentID FROM tbl_payment WHERE paymentID = '$temp'");
        if(!$res && $not_inserted) {
            $not_inserted = false;
        }
    }
    $id = $temp;

    $add_sql = mysqli_query($conn, "INSERT INTO tbl_payment (paymentID, paymentName, paymentDesc) 
                            VALUES ('$id', '$name', '$desc')");
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

        $logContent = "Added Payment Type ".$id." with the following identifications:
            Payment Name: ".$name.",
            Payment Description: ".$desc."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Add Payment Type', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Add Successful')</script>";
            echo "<script>window.open('manage_payment.php','_self')</script>";
        }
    }
    else {
        echo "<script>alert('Add Failed')</script>";
        echo "<script>window.open('manage_payment.php','_self')</script>";
    }
}
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Add New Payment</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">Payment Information</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="name">
                                                        <strong>Payment Name</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="name" placeholder="Enter Payment Name" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label class="form-label" for="desc">
                                                        <strong>Description</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="desc" placeholder="Enter Payment Description" name="desc" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class ="row">
                                            <div class="col-lg-2">
                                                <div class="col-mb-2">
                                                    <button class="btn btn-primary btn-sm" type="submit" name="add">Add Payment</button>
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