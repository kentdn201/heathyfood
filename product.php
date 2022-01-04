<?php
include("include/header.php"); 
$user = (isset($_SESSION['user']))? $_SESSION['user'] : [];
$id = $_GET['id'];
$product_query = pg_query($conn, "SELECT * FROM tbl_product, tbl_product_category WHERE tbl_product.categoryid = '$id' AND tbl_product_category.categoryid = tbl_product.categoryid");
$product_res = pg_fetch_assoc($product_query);
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
					<li><?php echo $product_res['categoryname']?></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->
	<!-- top Products -->
	<div class="ads-grid">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l"><?php echo $product_res['categoryName']?>
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
			<!-- product left -->
			<div class="side-bar col-md-3">
				<!-- price range -->
				<div class="range">
					<h3 class="agileits-sear-head">Price range</h3>
					<ul class="dropdown-menu6">
						<li>
							<div id="slider-range"></div>
							<input type="text" id="amount" style="border: 0; color: #ffffff; font-weight: normal;" />
						</li>
					</ul>
				</div>
				<!-- //price range -->
				
				<!-- deals -->
				<div class="deal-leftmk left-side">
				<h3 class="agileits-sear-head">Special Deals</h3>
				<?php
					$sql = "SELECT * FROM tbl_product LIMIT 6"; // sql command
					$result = pg_query($conn, $sql);
					// Start While loop
					foreach($result as $row){ 
					?>
					<div class="special-sec1">
						<div class="col-xs-4 img-deals">
							<?php
								$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productid = '".$row['productid']."' LIMIT 1");
								foreach($product_image_query as $product_image){
							?>
							<img  src="../shared_assets/img/product/<?php echo $product_image['productid']?>/<?php echo $product_image['imagename']?>" alt="" style="width:100%">
							<?php } ?>
						</div>
						<div class="col-xs-8 img-deal1">
							<h3><?php echo $row['productname']?></h3>
							<a href="single.php?id=<?php echo $row['productid']?>"><?php echo $row['productprice']?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					
					<?php

					} //End while

				?>
				</div>
				
				<!-- //deals -->
			</div>
			<!-- //product left -->
			<!-- product right -->
			<div class="agileinfo-ads-display col-md-9 w3l-rightpro">
				<div class="wrapper">
					<!-- first section -->

					<div class="product-sec1">
					<?php
					// Start While loop
					foreach($product_query as $row){ 
					?>
						<div class="col-xs-4 product-men">
							<div class="men-pro-item simpleCart_shelfItem">
								<div class="men-thumb-item" style="margin-top:10px">
									<?php
									$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productid = '".$row['productid']."' LIMIT 1");
									foreach($product_image_query as $product_image){
									?>
									<img src="../shared_assets/img/product/<?php echo $product_image['productid']?>/<?php echo $product_image['imagename']?>" alt="" style="width:100%; height:200px;">
									<?php } ?>
									<div class="men-cart-pro">
										<div class="inner-men-cart-pro">
											<a href="single.php?id=<?php echo $row['productid']?>" class="link-product-add-cart">Quick View</a>
										</div>
									</div>
								</div>
								<div class="item-info-product ">
									<h4>
										<a href="single.php"><?php echo $row['productname']?></a>
									</h4>
									<div class="info-product-price">
										<?php
											if($row['inventoryquantity'] <= 0) { ?>
												<span class="item_price">Out of Stock</span>
											<?php }
											else { ?>
												<span class="item_price"><?php echo number_format($row['productprice'])?> VND</span>
											<?php }
										?>
									</div>
									<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
										<form action="cartxuly.php?id=<?php echo $row['productID']?>" method="post">
											<fieldset>
												<input type="hidden" name="name" value="<?php echo $row['productname']?>" />
												<input type="hidden" name="price" value="<?php echo $row['productprice']?>"/>
												<?php
												if($row['inventoryquantity'] > 0) { ?>
													<input type="submit" name="addcart" value="Add to cart" class="button" />
												<?php }
												else { ?>
													<input type="submit" name="addcart" value="Add to cart" class="button" disabled/>
												<?php }
												?>
											</fieldset>
										</form>
									</div>
								</div>
							</div>
						</div>
						<?php
							} //End while
						?>
						<div class="clearfix"></div>
					</div>
					<!-- //first section -->
					<!-- 2nd section -->
				</div>
			</div>
			<!-- //product right -->
		</div>
	</div>
	<!-- //top products -->
<?php 
include("include/footer.php");
?>
