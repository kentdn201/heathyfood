<?php 
include("include/header.php");

$id = $_GET['id'];
$sql = mysqli_query($conn, "SELECT * FROM tbl_order, tbl_payment WHERE orderID = '$id' AND tbl_payment.paymentID = tbl_order.paymentID");
$rows = mysqli_fetch_assoc($sql);

if(isset($_POST['update'])) {
    $status;
    $status_res = $_POST['status'];
    switch($status_res) {
        case 1:
        {
            $status = 'Pending';
            break;
        }
        case 2:
        {
            $status = 'Shipping';
            break;
        }
        default:
        {
            $status = 'Completed';
            break;
        }
    }
    $update_sql = "UPDATE tbl_order SET currentStatus = '$status' WHERE orderID = '$id'";
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

        $logContent = "Updated Order ".$id." with the following changes:
        Order Status: ".$rows['currentStatus']." -> ".$status."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Update Order Status', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Update Successful')</script>";
            echo "<script>window.open('manage_order.php','_self')</script>";
        }
    }else{
        echo "<script>alert('Update Failed')</script>";
        echo "<script>window.open('manage_order.php','_self')</script>";
    }
}

?>
                    <div class="container-fluid">
                    <h3 class="text-dark mb-1">Update Order Status</h3>
                    <div class="row mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Order ID: <?php echo $rows['orderID']?></p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="time">
                                                            <strong>Placement Time</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="time" placeholder="<?php echo $rows['createdTime']?>" name="time" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="payment">
                                                            <strong>Payment</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="payment" placeholder="<?php echo $rows['paymentName']?>" name="payment" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="status">
                                                            <strong>Status</strong>
                                                        </label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="1" >Pending </option>
                                                            <option value="2" >Shipping </option>
                                                            <option value="3" >Completed </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col">
                                                    <div class="mb-2"><button class="btn btn-primary btn-sm" type="submit" name="update">Confirm Update</button></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">Customer Detail</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">
                                                    <strong>Customer Name</strong>
                                                </label>
                                                <input type="text" class="form-control" id="name" placeholder="<?php echo $rows['customerName']?>" name="name" readonly/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="phone">
                                                    <strong>Phone Number</strong>
                                                </label>
                                                <input type="tel" class="form-control" id="phone" placeholder="<?php echo $rows['customerPhone']?>" name="phone" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class ="row">
                                        <div class ="col">
                                            <div class ="mb-3">
                                                <label class="form-label" for="address">
                                                    <strong>Shipping Address</strong>
                                                </label>
                                                <input type="text" class="form-control" id="address" placeholder="<?php echo $rows['customerAddress']?>" name="address" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">Order Detail</p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="table">
                                                
                                    </div>
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

<script>

    $(document).ready(function(){
        
        load_data();

        //Display Fetched Data
        function load_data() {
            $.ajax({
                url:"fetch_order_detail.php?id=<?php echo $rows['orderID']?>",
                method:"POST",
                success:function(data) {
                    $('#table').html(data);
                }
            });
        }
        
    });

</script>