<?php 
    include("include/header.php");
    $user = (isset($_SESSION['user']))? $_SESSION['user'] : [];
?>
<style>
    .mainContent{
        border: .5px solid gray;
        border-radius: 4px;
    }

    .mainContent .leftContent{
        float:left;
    }

    .mainContent .rightContent{
        float:right;
    }
</style>
<?php
    if(isset($_SESSION['user'])){
?>
<?php
    $sql = "SELECT * FROM tbl_order WHERE accountID = '{$user['accountID']}' ORDER BY createdTime DESC";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)==0) { ?>
        <h4 style="text-align:center; margin-top: 100px;">Placed Order will be displayed here</h4>    
    <?php }
    while($order = mysqli_fetch_array($query)){
?>
<div class="container mt-5 mb-5" style="margin-top:10px">
    <div class="mainContent">
        <div class="left-content">
            <div class="col-md-6 mt-1">
                <a href="orderdetail.php?id=<?php echo $order['orderID']?>">
                    <h5 class="voucher__Name">Order ID: <?php echo $order['orderID']?></h5>
                </a>
                    <!-- <div class="mt-1 mb-1 spec-1"><span>100% cotton</span><span class="dot"></span><span>Light weight</span><span class="dot"></span><span>Best finish<br></span></div>
                    <div class="mt-1 mb-1 spec-1"><span>Unique design</span><span class="dot"></span><span>For men</span><span class="dot"></span><span>Casual<br></span></div> -->
                <p class="text-justify text-truncate para mb-0" style="font-size:15px"><?php echo $order['currentStatus']?> <br><br></p>
                <p class="text-justify text-truncate para mb-0" style="font-size:15px">Created Date: <?php echo $order['createdTime']?><br><br></p>
            </div>
        </div>
        <div class="right-content">
            <div class="d-flex flex-row align-items-center">
                <h4 class="mr-1">Price : </h4><h4 class="mr-1"><?php echo number_format($order['totalPrice'])?> VND</h4>
            </div>
                <div class="d-flex flex-column mt-4">
                    <a href="orderdetail.php?id=<?php echo $order['orderID']?>" class="btn-voucher btn-outline-primary btn-sm mt-2" type="button">View Order Detail</a>
                </div>
            </div>  
        </div>
    </div>
</div>
<?php  } ?>
<?php
    } else {
?>
    <h3 style="text-align:center; margin-top: 100px;">You need to login to see this content</h3>
<?php
    }
?>



<?php 
include("include/footer.php");
?>