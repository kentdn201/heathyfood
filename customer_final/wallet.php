<?php
    include("include/header.php");
    $user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
?>
    <link rel="stylesheet" href="../shared_assets/css/wallet.css">
    <!-- page -->
    <div class="services-breadcrumb">
        <div class="agile_inner_breadcrumb">
            <div class="container">
                <ul class="w3_short">
                    <li>
                        <a href="index.php">Home</a>
                        <i>|</i>
                    </li>
                    <li>Wallet</li>
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
                        <li class="contentList"><a href="history.php"><i class="fa fa-shopping-cart iconFont"></i>Cart History</a></li>
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
                    <div class="currentMoney"><a href="getVoucher.php">Get voucher ></a></div>

                    <!-- clearfix -->
                    <div class="clearfix"></div>
                </div>
                <div class="contentWalletRight">
                <button class="tablink" onclick="openPage('Home', this, 'rgb(236, 205, 205)')"  id="defaultOpen">All History</button>
                <button class="tablink" onclick="openPage('News', this, 'rgb(236, 205, 205)')">Got</button>
                <button class="tablink" onclick="openPage('Contact', this, 'rgb(236, 205, 205)')">Used</button>
                    <div id="Home" class="tabcontent">
                        <div class="clearfix"></div>
                        <?php
                            $sql = mysqli_query( $conn, "SELECT * FROM tbl_wallet_history INNER JOIN tbl_account_wallet 
                            ON tbl_wallet_history.walletID = tbl_account_wallet.walletID WHERE tbl_account_wallet.accountID ='{$user['accountID']}'
                            ORDER BY createdTime DESC");
                            while( $history = mysqli_fetch_array($sql)){
                        ?>
                        <div class="mainContent">
                        <div class="leftContent">
                            <img src="../shared_assets/img/coin.jpg" alt="img" class="imgWallet">
                            <div class="contentWalletLeft"><?php echo $history['historyName']?></div>
                        </div>
                        <div class="rightContent">
                            <?php
                                if($history['historyName'] == 'Redeem voucher'){
                            ?>
                                <div class="contentWalletRight">- <?php echo $history['historyAmount']?> Coin</div>
                            <?php
                                } else {
                            ?>
                                <div class="contentWalletRight">+ <?php echo $history['historyAmount']?> Coin</div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <?php } ?>
                    </div>

                    <div id="News" class="tabcontent">
                    <div class="clearfix"></div>
                        <?php
                            $sql = mysqli_query( $conn, "SELECT * FROM tbl_wallet_history INNER JOIN tbl_account_wallet 
                            ON tbl_wallet_history.walletID = tbl_account_wallet.walletID 
                            WHERE tbl_account_wallet.accountID ='{$user['accountID']}' AND tbl_wallet_history.historyName ='Buy Product'
                            ORDER BY createdTime DESC");
                            while( $history = mysqli_fetch_array($sql)){
                        ?>
                        <div class="mainContent">
                        <div class="leftContent">
                            <img src="../shared_assets/img/coin.jpg" alt="img" class="imgWallet">
                            <div class="contentWalletLeft"><?php echo $history['historyName']?></div>
                        </div>
                        <div class="rightContent">
                            <div class="contentWalletRight">+ <?php echo $history['historyAmount']?> Coin</div>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <?php } ?>
                    </div>

                    <div id="Contact" class="tabcontent">
                    <div class="clearfix"></div>
                        <?php
                            $sql = mysqli_query( $conn, "SELECT * FROM tbl_wallet_history INNER JOIN tbl_account_wallet 
                            ON tbl_wallet_history.walletID = tbl_account_wallet.walletID 
                            WHERE tbl_account_wallet.accountID ='{$user['accountID']}' AND tbl_wallet_history.historyName ='Redeem voucher'
                            ORDER BY createdTime DESC");
                            while( $history = mysqli_fetch_array($sql)){
                        ?>
                        <div class="mainContent">
                        <div class="leftContent">
                            <img src="../shared_assets/img/coin.jpg" alt="img" class="imgWallet">
                            <div class="contentWalletLeft"><?php echo $history['historyName']?></div>
                        </div>
                        <div class="rightContent">
                            <div class="contentWalletRight">- <?php echo $history['historyAmount']?> Coin</div>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <?php } ?>       
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>


    <script>
        function openPage(pageName,elmnt,color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = color;
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

<?php 
    include("./include/footer.php");
?>  