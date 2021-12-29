<?php
    include("include/header.php");

    $user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
    $cart = (isset($_SESSION['cart']))? $_SESSION['cart'] : [];
	$voucher = (isset($_SESSION['voucher']))? $_SESSION['voucher'] : [];
?>
    <link rel="stylesheet" href="../shared_assets/css/getVoucher.css">
    <!-- page -->
    <div class="services-breadcrumb">
        <div class="agile_inner_breadcrumb">
            <div class="container">
                <ul class="w3_short">
                    <li>
                        <a href="index.php" class="active">Home</a>
                        <i>|</i>
                    </li>
                    <li>
                        <a href="wallet.php">Wallet</a> 
                        <i>|</i>
                    </li>
                    <li>Get Voucher</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Wallet content -->
    <div id="wallet">
        <div class="container">
            <div class="walletLeft">
                <div class="titleWallet"><i class="fa fa-user-circle iconTitle"></i><?php echo $user['accountFullname']?></div>
                <div class="contentWalletLeft">
                    <ul>
                    <li class="contentList"><a href="cusprofile.php"><i class="fa fa-user iconFont"></i>My Infomation</a></li>
                        <li class="contentList"><a href="#"><i class="fa fa-shopping-cart iconFont"></i>Cart History</a></li>
                        <li class="contentList"><a href="voucher.php"><i class="fa fa-exclamation-circle iconFont"></i>Voucher</a></li>
                    </ul>
                </div>
            </div>
            <div class="walletRight">
                <div class="headWalletRight">
                    <!-- head -->
                    <?php
                        $sql = "SELECT * FROM tbl_account_wallet WHERE accountID = '{$user['accountID']}'";
                        $result = mysqli_query($conn, $sql);
                        while($wallet = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="currentBalance"><?php echo $wallet['walletBalance'] ?>: cent in your wallet</div>

                    <?php } ?>
                    <div class="currentMoney"><a href="wallet.php">< Back To Wallet</a></div>

                    <!-- clearfix -->
                    <div class="clearfix"></div>
                </div>
                <?php
                    $sql = "SELECT * FROM tbl_voucher_type WHERE voucherCost > 0"; // sql command
                    $result = mysqli_query($conn, $sql);
                    // Start While loop
                    while($row = mysqli_fetch_assoc($result)){ 
                ?>
                <div class="contentWalletRight">
                        <div class="mainContent">
                            <div class="mainContentX">
                                <form action="voucherxlUser.php?id=<?php echo $row['typeID']?>" method="POST">
                                <div class="leftVoucher">
                                    <div class="imgVoucher">
                                        <img src="../shared_assets/img/voucher.jpg" alt="voucher">
                                    </div>
                                    <div class="contentVoucher">
                                        <p class="txtContent"><?php echo $row['typeDesc']?></p>
                                        <p class="txtPrice">Coin to get: <b><?php echo $row['voucherCost']?> coin<b></p>
                                        <p class="txtTime">Time: 28/10/2021</p>
                                    </div>
                                </div>
                                    <div class="rightVoucher">
                                        <div class="btnGetVoucher">
                                            <button type="submit" name="submit">Get</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<?php 
    include("./include/footer.php");
?>  