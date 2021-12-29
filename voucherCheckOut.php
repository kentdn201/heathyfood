<?php 
    include("include/header.php");

    $user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
	$cart = (isset($_SESSION['cart']))? $_SESSION['cart'] : [];
	$voucher = (isset($_SESSION['voucher']))? $_SESSION['voucher'] : [];
?>
<div class="container mt-5 mb-5">
        <?php
            if(isset($_SESSION['user'])){
                $user = $user['accountID'];
        ?>
        <h3 class="tittle-w3l">My voucher
        <?php
        $sql = "SELECT * FROM tbl_voucher_type INNER JOIN tbl_account_voucher ON tbl_voucher_type.typeID = tbl_account_voucher.typeID
        WHERE accountID = '{$user}' AND voucherCost > 0 ORDER BY createdTime DESC"; // sql command
        $result = mysqli_query($conn, $sql); 
        if(mysqli_num_rows($result) > 0){
        ?>
        
        <form action="wallet.php">
            <div class="d-flex flex-column mt-4" style="width: 30%; margin-left: 100px; float:left">
                <button class="btn-voucher btn-outline-primary btn-sm mt-2" type="submit">Back to Wallet</button>
            </div>
        </form>
        <?php } ?>
        <?php
            if(empty($cart) != 1){
        ?>
            <form action="checkout.php">
                <div class="d-flex flex-column mt-4" style="width: 30%; margin-right: 62px; float: right">
                    <button class="btn-voucher btn-outline-primary btn-sm mt-2" type="submit">Back to Check Out</button>
                </div>
            </form>
        <?php
            }
        ?>
                    <span class="heading-style">
                        <i></i>
                        <i></i>
                        <i></i>
                    </span>
            </h3>

        <div class="d-flex justify-content-center row-voucher ">
        <?php
        $sql = "SELECT * FROM tbl_voucher_type INNER JOIN tbl_account_voucher ON tbl_voucher_type.typeID = tbl_account_voucher.typeID
        WHERE accountID = '{$user}' AND voucherCost > 0 ORDER BY createdTime DESC"; // sql command
        $result = mysqli_query($conn, $sql); 
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){ 
        ?>
        <div class="col-md-9">
            <div class="row-voucher  p-2 bg-white border-voucher rounded">
                <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="../shared_assets/img/voucher.jpg"></div>
                <div class="col-md-6 mt-1">
                    <h2 class="voucher_Name"><?php echo $row['typeName']?></h2>
                    <p class="voucher_Name"><?php echo $row['typeDesc']?></p>
                </div>
                <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                    <div class="d-flex flex-row-voucher  align-items-center">
                       <!--  <h4 class="mr-1">$13.99</h4><span class="strike-text">$20.99</span> -->
                    </div>
                    <h6 class="text-success"></h6>
                    <form action="voucherxuly.php">
                        <div class="d-flex flex-column mt-4">
                            <input type="hidden" name="id" value="<?php echo $row['voucherID']?>">
                            <button class="btn-voucher btn-outline-primary btn-sm mt-2" type="submit" type="button">Add To Check Out</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
                <?php } //End while ?>
        </div>
        <?php
        } else {
            echo '<h3 style="margin-left: 220px;">You need reddeem voucher --> <a href="getVoucher.php"> Click here to get voucher</a> </h3>';
        }
        ?> 
    </div>
    <?php
        } else {
    ?>
    <h3 style="text-align:center; margin-top: 120px;">You are not logged in to view this feature</h3>
    <?php
        }
    ?>
</div>


<?php 
include("include/footer.php");
?>