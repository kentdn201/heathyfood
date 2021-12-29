<?php 
include("include/header.php");

if($user['roleID'] != 'role_0') { ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">You don't have the sufficient authority to access this page</h3>
    </div>
<?php }
else {

$id = $_GET['id'];
$display_sql = mysqli_query($conn, "SELECT * FROM tbl_product, tbl_product_category WHERE productID = '$id' AND tbl_product.categoryID = tbl_product_category.categoryID");
$rows = mysqli_fetch_assoc($display_sql);

if(isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $category = $_POST['category'];

    $update_sql = "UPDATE tbl_product SET productName ='$name', productPrice = '$price', productDesc = '$desc', categoryID = '$category' WHERE productID = '$id'";
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

        $logContent = "Updated Product ".$id." with the following changes:
        Product Name: ".$rows['productName']." -> ".$name.",
        Product Price: ".$rows['productPrice']." -> ".$price.",
        Product Description: ".$rows['productDesc']." -> ".$desc.",
        Product Category: ".$rows['categoryID']." -> ".$category."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Update Category', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Update Successful')</script>";
            echo "<script>window.open('manage_product.php','_self')</script>";
        }
    }else{
        echo "<script>alert('Update Failed')</script>";
        echo "<script>window.open('manage_product.php','_self')</script>";
    }
}

$category_list = mysqli_query($conn, "SELECT * FROM tbl_product_category");
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Update Product</h3>
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
                                                        <input type="text" class="form-control" id="name" value="<?php echo $rows['productName']?>" name="name" />
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="category">
                                                            <strong>Product Category</strong>
                                                        </label>
                                                        <select name="category" id="category" class="form-control">
                                                            <?php foreach($category_list as $key => $value) { 
                                                                if(strcmp($value['categoryID'], $rows['categoryID']) == 0) { ?>
                                                                    <option value="<?php echo $rows['categoryID'] ?>" selected><?php echo $rows['categoryName'] ?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $value['categoryID'] ?>" ><?php echo $value['categoryName'] ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="price">
                                                            <strong>Price (VND)</strong>
                                                        </label>
                                                        <input type="number" class="form-control" id="price" value="<?php echo $rows['productPrice']?>" name="price" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="desc">
                                                            <strong>Product Description</strong>
                                                        </label>
                                                        <textarea class="form-control" id="desc" name="desc" placeholder="<?php echo $rows['productDesc']?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col-lg-2">
                                                    <div class="mb-2">
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
                    <div class="row mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Product Images</p>
                                    </div>
                                    <div class="card-body">
                                        <div align="right">
                                            <input type="file" name="upload_img" id="upload_img" multiple />
                                            <br />
                                            <span class="text-muted">Only .jpg, png, .gif file allowed</span>
                                            <span id="notification"></span>
                                            <br />
                                        </div>
                                        <div class="table-responsive" id="table">
                                                
                                        </div>
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

<script>

    $(document).ready(function(){
        
        load_data();

        //Display Fetched Data
        function load_data() {
            $.ajax({
                url:"fetch_img.php?id=<?php echo $rows['productID']?>",
                method:"POST",
                success:function(data) {
                    $('#table').html(data);
                }
            });
        }

        //Upload Image(s)
        $('#upload_img').change(function() {
            var noti = '';
            var form_data = new FormData();
            var files = $('#upload_img')[0].files;
            if(files.length > 10)
            {
                noti += 'You can not select more than 10 files';
            }
            else
            {
                for(var i=0; i<files.length; i++)
                {
                    var name = document.getElementById("upload_img").files[i].name;
                    var ext = name.split('.').pop().toLowerCase();
                    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
                    {
                    noti += '<p>Invalid '+i+' File</p>';
                    }
                    var oFReader = new FileReader();
                    oFReader.readAsDataURL(document.getElementById("upload_img").files[i]);
                    var f = document.getElementById("upload_img").files[i];
                    form_data.append("file[]", document.getElementById('upload_img').files[i]);
                }
            }
            if(noti == '')
            {
                $.ajax({
                    url:"upload_img.php?id=<?php echo $rows['productID']?>",
                    method:"POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend:function() {
                        $('#notification').html('<br /><label class="text-primary">Uploading...</label>');
                    },   
                    success:function(data) {
                        $('#notification').html('<br /><label class="text-success">Uploaded</label>');
                        load_data();
                        console.log(data);
                    }
                });
            }
            else
            {
                $('#upload_img').val('');
                $('#notification').html("<span class='text-danger'>"+noti+"</span>");
                return false;
            }
        });
        
        //Delete Data
        $(document).on('click', '.delete', function(){
            var imageID = $(this).attr("id");
            var imageName = $(this).data("name");
            if(confirm("Are you sure you want to remove this data?"))
            {
                $.ajax({
                    url:"delete_img.php",
                    method:"POST",
                    data:{imageID:imageID, imageName:imageName},
                    success:function(data)
                    {
                        load_data();
                        alert("Image removed");
                    }
                });
            }
        }); 
    });

</script>