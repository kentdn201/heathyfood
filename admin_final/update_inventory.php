<?php 
include("include/header.php");

$id = $_GET['id'];
$display_sql = mysqli_query($conn, "SELECT * FROM tbl_product, tbl_product_category WHERE productID = '$id' AND tbl_product.categoryID = tbl_product_category.categoryID");
$rows = mysqli_fetch_assoc($display_sql);

if(isset($_POST['update'])) {
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    if($quantity > 0) {
        $status = 'Available';
    } else {
        $status = 'Empty';
    }

    $update_sql = "UPDATE tbl_product SET productStatus = '$status', inventoryQuantity = '$quantity' WHERE `productID` = '$id'";
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

        $logContent = "Updated Product Inventory ".$id." with the following changes:
        Product Status: ".$rows['productStatus']." -> ".$status.",
        Product Quantity: ".$rows['productQuantity']." -> ".$quantity."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Update Product Inventory', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Update Successful')</script>";
            echo "<script>window.open('manage_inventory.php','_self')</script>";
        }
    }else{
        echo "<script>alert('Update Failed')</script>";
        echo "<script>window.open('manage_inventory.php','_self')</script>";
    }
}

?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Update Inventory</h3>
                    <div class="row mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Product ID: <?php echo $rows['productID']?></p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name">
                                                            <strong>Product Name</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="name" placeholder="<?php echo $rows['productName']?>" name="name" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="category">
                                                            <strong>Product Category</strong>
                                                        </label>
                                                        <input type="category" class="form-control" id="category" placeholder="<?php echo $rows['categoryName']?>" name="category" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="status">
                                                            <strong>Status</strong>
                                                        </label>
                                                        <input type="status" class="form-control" id="status" placeholder="<?php echo $rows['productStatus']?>" name="status" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="quantity">
                                                            <strong>Quantity</strong>
                                                        </label>
                                                        <input type="number" class="form-control" id="quantity" value="<?php echo $rows['inventoryQuantity']?>" name="quantity" />
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
                    <div class="card shadow mb-5"></div>
                </div>
            </div>
            <?php 
            include("include/footer.php");
            ?>
</body>

</html>