<?php 
include("include/header.php");

if($user['roleID'] != 'role_0') { ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">You don't have the sufficient authority to access this page</h3>
    </div>
<?php }
else {

if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $category = $_POST['category'];

    $count = mysqli_num_rows(mysqli_query($conn, "SELECT productID FROM tbl_product"));
    $not_inserted = true;
    for($i = 0; $i <= $count; $i++) {
        $temp = "product_".$i;
        $res = mysqli_query($conn, "SELECT productID FROM tbl_product WHERE productID = '$temp'");
        if(!$res && $not_inserted) {
            $not_inserted = false;
        }
    }
    $id = $temp;

    $add_sql = mysqli_query($conn, "INSERT INTO tbl_product (productID, productName, productPrice, productDesc, productStatus, inventoryQuantity, categoryID) 
                            VALUES ('$id', '$name', '$price', '$desc', 'Empty', 0, '$category')");
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

        $logContent = "Added Product ".$id." with the following identifications:
            Product Name: ".$name.",
            Product Price: ".$price.",
            Product Description: ".$desc.",
            Product Category: ".$category."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Add Product', '$logContent', '".$user['accountID']."')");

        if($log_sql) {
            echo "<script>alert('Add Successful')</script>";
            echo "<script>window.open('manage_product.php','_self')</script>";
        }
    }
    else {
        echo "<script>alert('Add Failed')</script>";
        echo "<script>window.open('manage_product.php','_self')</script>";
    }
}

$category_sql = mysqli_query($conn, "SELECT * FROM tbl_product_category");

?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Add New Product</h3>
                    <div class="row mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Product Information</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name">
                                                            <strong>Product Name</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="name" placeholder="Enter Product Name" name="name" />
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="category">
                                                            <strong>Product Category</strong>
                                                        </label>
                                                        <select name="category" id="category" class="form-control">
                                                            <option value="0">Select Product Category</option>
                                                            <?php foreach($category_sql as $key => $value) { ?>
                                                                <option value="<?php echo $value['categoryID'] ?>"><?php echo $value['categoryName'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="price">
                                                            <strong>Price (VND)</strong>
                                                        </label>
                                                        <input type="number" class="form-control" id="price" placeholder="Enter Product Price" name="price" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name">
                                                            <strong>Product Description</strong>
                                                        </label>
                                                        <textarea class="form-control" id="desc" name="desc" placeholder="Enter Product Description" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col-lg-2">
                                                    <div class="mb-2"><button class="btn btn-primary btn-sm" type="submit" name="add">Add Product</button></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            include("include/footer.php");
            }
            ?>
</body>

</html>