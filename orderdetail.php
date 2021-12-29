<?php 
    include("include/header.php");
?>
<div class="container" style="margin-top:10px"> 
<?php 
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_order WHERE orderID = '{$id}'";
    $query = pg_query($conn, $sql);
    while($order = pg_fetch_assoc($query)){
		echo '
		<h2>Order ID: '.$order['orderID'].'</h2>
		<p>Order time: '.$order['createdTime'].'</p>
		<p>Customer: '.$order['customerName'].'</p>
		<p>Phone: '.$order['customerPhone'].'</p>
		<p>Address: '.$order['customerAddress'].'</p>
		<p>Email: '.$order['customerEmail'].'</p>
		<p>Status: '.$order['currentStatus'].'</p>
		';
	} 
?>
    <div class="checkout-right">
				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>ID</th>
								<th>Product</th>
								<th>Quality</th>
								<th>Product Name</th>
								<th>Single Price</th>
								<th>Total Price in Product</th>
							</tr>
						</thead>
                        <?php 
                        ?>
                        <?php
                            $sql = "SELECT * FROM tbl_order_detail, tbl_order WHERE tbl_order.orderID = tbl_order_detail.orderID AND tbl_order.orderID = '{$id}'";
                            $query = pg_query($conn, $sql);
                            while($order = pg_fetch_array($query)){
                                $totalPrice = $order['totalPrice'];
                        ?>
						<tbody>
							<tr class="rem">
                                <?php
                                    $sql1 = "SELECT * FROM tbl_product WHERE productID='{$order['productID']}'";
                                    $query1 = pg_query($conn, $sql1);
                                    while($product = pg_fetch_assoc($query1)){
                                ?>
								<td class="invert"><?php echo $product['productID']?></td>
								<td class="invert-image">
									<a href="single.php?id=<?php echo $product['productID']?>">
									<?php
										$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productID = '".$product['productID']."' LIMIT 1");
										foreach($product_image_query as $product_image){
									?>
									<img src="../shared_assets/img/product/<?php echo $product_image['productID']?>/<?php echo $product_image['imageName']?>" alt="" width="100%">
									<?php } ?>
									</a>
								</td>
								<td class="invert">
									<div class="quantity">
                                        <?php echo $order['orderedQuantity']?>
									</div>
								</td>
								<td class="invert"><?php echo $product['productName']?></td>
								<td class="invert"><?php echo number_format($order['currentPrice'])?> VND</td>
								<td class="invert"><?php echo number_format($order['orderedQuantity']* $order['currentPrice']) ?> VND</td>
                                <?php } ?>     
							</tr>
						</tbody>
                        <?php  } ?> 
						<tr>
							<td colspan = "5">Voucher Apply: </td>
								<?php
                                    $sql = "SELECT * FROM tbl_order, tbl_voucher_type 
                                    WHERE tbl_order.voucherID = tbl_voucher_type.typeID 
                                    AND tbl_order.orderID = '{$id}'";
                                    $query = pg_query($conn, $sql);
                                    if(pg_num_rows($query) > 0){
                                        while($order = pg_fetch_array($query)){
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
							<td colspan = "5">Total Price: </td>
							<td colspan = "2"><?php echo number_format($totalPrice)?> VND</td>
						</tr>
					</table>
				</div>
			</div>
            <div class="checkout-right-basket" style="float:left">
				<a href="history.php">Back to Order History
					<span class="fa fa-hand-o-left" aria-hidden="true"></span>
				</a>
			</div>
    </div>
<?php 
include("include/footer.php");
?>

