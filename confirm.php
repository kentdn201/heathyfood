<?php
include("include/header.php");

$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
$cart = (isset($_SESSION['cart']))? $_SESSION['cart'] : [];
$voucher = (isset($_SESSION['voucher']))? $_SESSION['voucher'] : [];

?>
<style>
    .txtText{
        font-size: 20px;
	}
</style>
<?php
if(!empty($cart)) {
    if(isset($_POST['checkout'])) {
        $id = rand(0,10000);
        $name = $_POST['name'];
        $paytype = $_POST['paytype'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $currentStatus = 'Pending';
        $email = $_POST['email'];
        $totalPrice = $_POST['totalPrice'];
        $voucherID = '';
        $voucherType = '';
        $accountID = '';

        $sql = '';
        
        if($user && $voucher) {
            $voucherID = $voucher['id'];
            $voucherType = $voucher['type'];
            $accountID = $user['accountID'];
            $sql = "INSERT INTO tbl_order (orderID, currentStatus, customerName, paymentID, customerAddress, customerPhone, customerEmail, totalPrice, voucherID, accountID) 
                    VALUES ('$id', '$currentStatus', '$name' , '$paytype', '$address', '$phone',  '$email', '$totalPrice' ,'$voucherType', '$accountID')";
        }
        else if($user && !$voucher) {
            $accountID = $user['accountID'];
            $sql = "INSERT INTO tbl_order (orderID, currentStatus, customerName, paymentID, customerAddress, customerPhone, customerEmail, totalPrice, accountID) 
                    VALUES ('$id', '$currentStatus', '$name' , '$paytype', '$address', '$phone',  '$email', '$totalPrice', '$accountID')";
        }
        else {
            $sql = "INSERT INTO tbl_order (orderID, currentStatus, customerName, paymentID, customerAddress, customerPhone, customerEmail, totalPrice) 
                    VALUES ('$id', '$currentStatus', '$name' , '$paytype', '$address', '$phone',  '$email', '$totalPrice')";
        }

        if(isset($_POST['submit'])) {
            $query = mysqli_query($conn, $sql);
            if($query) {
                foreach($cart as $value){
                    mysqli_query($conn, "INSERT INTO tbl_order_detail (productID, orderID, orderedQuantity, currentPrice)
                    VALUES ('$value[id]', '$id', '$value[quantity]', '$value[price]')");
                }

                $wallet_sql = "UPDATE tbl_account_wallet SET walletBalance = '".$_POST['walletBalance']."' WHERE accountID = '".$user."'";
                if(!$wallet_sql) {
                    echo " ". mysqli_error($conn);
                }
                else {
                    $walletID = $_POST['walletID'];
                    $historyName = $_POST['historyName'];
                    $amount = $_POST['amount'];
                    $history_sql = "INSERT INTO tbl_wallet_history (historyName, historyAmount, walletID)
                                    VALUES ('$historyName', '$amount', '$walletID')";
                    $history_query = mysqli_query($conn, $history_sql);
                    if(!$history_sql) {
                        echo " ". mysqli_error($conn);
                    }
                    else {
                        unset($cart);
                        unset($voucher);
                        header("Location: index.php");
                    }
                }
            }
        }

        $paytype_query = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE paymentID = '{$paytype}'");
        $pay = mysqli_fetch_assoc($paytype_query);
        $paymentName = $pay['paymentName'];
    }

?>
<!-- page -->
    <div class="services-breadcrumb">
        <div class="agile_inner_breadcrumb">
            <div class="container">
                <ul class="w3_short">
                    <li>
                        <a href="index.php">Home</a>
                        <i>|</i>
                    </li>
                    <li>Check Out</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="privacy">
        <div class="container">
        <!-- tittle heading -->
            <h3 class="tittle-w3l">Check Out
                <span class="heading-style">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </h3>
            <div class="checkout-left">
                <div class="table-responsive">
                    <div class="timetable_sub">
                        <h2>Please confirm your order</h2>
                        <table style="width:50%">
                            <tr>
                                <th colspan = "2">Your information</th>
                            </tr>
                            <tr>
                                <td>Your name</td>
                                <td><?php echo $name?></td>
                            </tr>
                            <tr>
                                <td>Your phone number</td>
                                <td><?php echo $phone?></td>
                            </tr>
                            <tr>
                                <td>Your address</td>
                                <td><?php echo $address?></td>
                            </tr>
                            <tr>
                                <td>Your email</td>
                                <td><?php echo $email?></td>
                            </tr>
                            <tr>
                                <td>Your paytype</td>
                                <td><?php echo $paymentName?></td>
                            </tr>
                    </table>
                    <div class="clearfix"></div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div>
        <div class="container">
            <div class="checkout-right">
                <div class="table-responsive">
                    <table class="timetable_sub">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Quality</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Total Price in Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $totalPrice = 0;
                                $tt = 0;
                                $totalCoin = 0;
                            ?>
                            <?php 
                                foreach($cart as $key => $value):
                                    $tt = $value['price'] * $value['quantity'];
                                    $totalPrice += $tt;
                                    $totalCoin = $totalPrice / 100;
                                    
                            ?>
                            <tr class="rem">
                                <td class="invert"><?php echo $key ++ ?></td>
                                <td class="invert-image">
                                <a href="single.php?id=<?php echo $value['id'] ?>">
                                        <img src="../shared_assets/img/product/<?php echo $value['id'] ?>/<?php echo $value['image'] ?>" alt="" class="img-responsive">
                                    </a>
                                </td>
                                <td class="invert">
                                    <div class="quantity">
                                        <?php echo $value['quantity'] ?>
                                    </div>
                                </td>
                                <td class="invert"><?php echo $value['name'] ?></td>
                                <td class="invert"><?php echo number_format($value['price']) ?> VND</td>
                                <td class="invert"><?php echo number_format($tt) ?> VND</td>
                            </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan = "5">Total Price: </td>
                                <td colspan = "2"><?php echo number_format($totalPrice)?> VND</td>
                            </tr>
                            <tr>
                                <td colspan = "5">Voucher Apply: </td>
                                <?php
                                    $sql = "SELECT * FROM tbl_order, tbl_voucher_type 
                                    WHERE tbl_order.voucherID = tbl_voucher_type.typeID 
                                    AND tbl_order.orderID = '{$id}'";
                                    $query = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($query) > 0){
                                        while($order = mysqli_fetch_array($query)){
                                            echo '<td colspan = "2">'.$order['typeDesc'].'</td>
                                            ';
                                        }
                                    } else {
                                        echo '
                                            <td colspan = "2">Not using voucher</td>
                                        ';
                                    }    
                                ?>
                            </tr>
                            <tr>
                                <td colspan = "5">Total coin can get: </td>
                                <td colspan = "2">
                                <?php 
                                if($totalCoin <= 0){
                                        echo '0';
                                    } else {
                                        echo number_format($totalCoin);
                                    }
                                ?> 
                                Coin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if($paytype=='payment_0') { ?>
            <form method="POST">
                <div class="btn-checkout">
                    <button class="btn btn-primary btn-sm" type="submit" name="submit">Check Out</button>
                </div>
            </form>   
            <?php }
            else if($paytype=='payment_1') { ?>
            <div id="paypal-checkout">
            </div>
            <?php }
            ?>
        </div>
    </div>
<?php
}
else { ?>
    <h3 style="text-align: center; margin-top:100px">You have not added an product to your cart </h3>
<?php } 
include("include/footer.php");
?>

<script src="https://www.paypal.com/sdk/js?client-id=AZCF2XDJuhdh_qvyAHBNO81yEZmVbha7HQktr5_pMCZAnWpDzAjcAxryojF0TJu5fdtKGTeMYXW_qbY7&disable-funding=credit,card"></script>
<script>
      paypal.Buttons().render('#paypal-checkout');
</script>