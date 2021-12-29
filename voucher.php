<?php 
    require_once("include/conn.php");
    include("include/header.php");

    $user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
	$cart = (isset($_SESSION['cart']))? $_SESSION['cart'] : [];
	$voucher = (isset($_SESSION['voucher']))? $_SESSION['voucher'] : [];
?>
<div class="container mt-5 mb-5">
            <h3 class="tittle-w3l">Voucher
                    <span class="heading-style">
                        <i></i>
                        <i></i>
                        <i></i>
                    </span>
            </h3>
    <?php
        if(isset($_SESSION['user'])){
    ?>
        <div class="d-flex justify-content-center row-voucher ">
        <?php
        $sql = "SELECT * FROM tbl_voucher_type WHERE voucherCost > 0"; // sql command
        $result = pg_query($conn, $sql);
        // Start While loop
        while($row = pg_fetch_assoc($result)){ 
        ?>
        <div class="col-md-10">
            <div class="row-voucher  p-2 bg-white border-voucher rounded">
                <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="images/voucher.jpg"></div>
                <div class="col-md-6 mt-1">
                    <h2 class="voucher__Name"><?php echo $row['typeName']?></h2>
                    <p class="voucher__Name"><?php echo $row['typeDesc']?></p>
                    <div class="d-flex flex-row-voucher bottom-voucher ">
                    <span></span>
                    <p class="voucher__Name">Price to get: <?php echo number_format($row['voucherCost'])?> Coin<br><br></p>    
                    </div>
                </div>
                <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                    <div class="d-flex flex-row-voucher  align-items-center">
                       <!--  <h4 class="mr-1">$13.99</h4><span class="strike-text">$20.99</span> -->
                    </div>
                    <h6 class="text-success"></h6>
                    <div class="d-flex flex-column mt-4">
                        <button class="btn-voucher btn-outline-primary btn-sm mt-2" type="button">Add To Your Account</button>
                    </div>
                </div>
            </div>
            </div>
                <?php } //End while ?>
        </div>
    </div>
    <?php
        } else {
    ?>
    <h3 style="text-align:center;">You are not logged in to view this feature</h3>
    <?php
        }
    ?>
    
</div>
<?php 
include("include/footer.php");
?>