<?php
	include("include/header.php");
?>
<?php
	$cart = (isset($_SESSION['cart']))? $_SESSION['cart'] : [];
	$user = (isset($_SESSION['user']))? $_SESSION['user'] : [];
?>
	<style>
		.soluong {
			width: 80px;
			border-radius: 3px;
			border: 1px solid gray;
			margin-bottom: 10px;
		}

		.updateSL{
			width: 80px;
			border-radius: 3px;
			border: 1px solid #1accfd;
			margin-bottom: 10px;
			background-color: #1accfd;
			color: #fff;
		}

		.updateSL:hover{
			background: #2587c8;
			transition: 0.5s all;
			-webkit-transition: 0.5s all;
			-moz-transition: 0.5s all;
			-o-transition: 0.5s all;
			-ms-transition: 0.5s all;
			color: black;
		}
	</style>

	<!-- page -->
	<div class="services-breadcrumb">
		<div class="agile_inner_breadcrumb">
			<div class="container">
				<ul class="w3_short">
					<li>
						<a href="index.php">Home</a>
						<i>|</i>
					</li>
					<li>Cart</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->
	<!-- checkout page -->
	<div class="privacy">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l">Cart
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
			<?php
				if(empty($cart) != 1){
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

								<th>Price</th>
								<th>Total Price in Product</th>
								<th>Remove</th>
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
										<img src="../shared_assets/img/product/<?php echo $value['id']?>/<?php echo $value['image']?>" alt="" class="img-responsive">
									</a>
								</td>
								<td class="invert">
									<div class="quantity">
										<form action="cartxuly.php">
											<input type="hidden" name="action" value="update">
											<input type="hidden" name='id' value="<?php echo $value['id']?>">
											<div class="quantity-select">
												<input class="soluong" type="number" name="quantity" value="<?php echo $value['quantity'] ?>">
												<button type="submit" class="updateSL">Update</button>
											</div>
										</form>
									</div>
								</td>
								<td class="invert"><?php echo $value['name'] ?></td>
								<td class="invert"><?php echo number_format($value['price']) ?> VND</td>
								<td class="invert"><?php echo number_format($tt) ?> VND</td>
								<td class="invert">
									<div class="rem">
										<a href="cartxuly.php?id=<?php echo $value['id']?>&action=delete">
											<div class="close1" style="background: url(../shared_assets/img/close_1.png) no-repeat 0px 0px;"></div>
										</a>
									</div>
								</td>
							</tr>
							<?php endforeach ?>
							<tr>
								<td colspan = "5">Total Price: </td>
								<td colspan = "2"><?php echo number_format($totalPrice)?> VND</td>
							</tr>
							<?php							

							?>
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
			<div class="checkout-right-basket" style="float:left">
				<a href="checkout.php">Proceed With Checkout
					<span class="fa fa-hand-o-right" aria-hidden="true"></span>
				</a>
			</div>
			<div class="checkout-right-basket" style="float:right">
				<a href="unsetcart.php">Delete all in Cart
					<span class="fa fa-hand-o-right" aria-hidden="true"></span>
				</a>
			</div>
		</div>
		<?php
			} else {
		?> 
		<h3 style="text-align:center;">You have not added an product to your cart</h3>
		<?php
			}
		?>
	</div>
	<!-- //checkout page -->
	<!-- footer -->
<?php 
	include("include/footer.php");
?>