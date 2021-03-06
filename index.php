<?php
	include("include/header.php");
	$user = (isset($_SESSION['user']))? $_SESSION['user'] : [];
?>
	<!-- top Products -->
	<div class="ads-grid">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l">Our Top Products
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
						$query = "SELECT * FROM tbl_product LIMIT 6";
						$rs = pg_query( $conn, $query);
						if( pg_num_rows( $rs ) > 0) {
							while( $row = pg_fetch_assoc( $rs )){
					?>
					<div class="special-sec1">
						<a href="single.php?id=<?php echo $row['productid']?>">
							<div class="col-xs-4 img-deals">
							<?php
								$product_image_sql = "SELECT * FROM tbl_product_images WHERE productid = '".$row['productid']."' LIMIT 1";
								$product_image_query = pg_query($conn, $product_image_sql);
								if( pg_num_rows($product_image_query) > 0 ) {
								foreach($product_image_query as $product_image){
							?>
							<img src="../shared_assets/img/product/<?php echo $product_image['productid']?>/<?php echo $product_image['imagename']?>" alt="Lmao" width="100%">
							<?php 
									}
								}
							?>
							</div>
							<div class="col-xs-8 img-deal1">
								<h3><?= $row['productname']?></h3>
								<a href="single.php?id=<?php echo $row['productid']?>"><?php echo $row['productprice']?></a>
							</div>
						<div class="clearfix"></div>
						</a>
					</div>
					<?php 
							} // end while
						} // end if
					?>
				</div>
				<!-- //deals -->
			</div>
			<!-- //product left -->
			<!-- product right -->
				<div class="agileinfo-ads-display col-md-9">
					<?php 
						$sqlCategory = "SELECT * FROM tbl_product_category";
						$category_query = pg_query($conn, $sqlCategory);
						if( pg_num_rows( $category_query ) > 0) {
						foreach($category_query as $category) { 
					?>
					<div class="wrapper">
						<!-- first section (nuts) -->

						<div class="product-sec1">
							<h3 class="heading-tittle"><?php echo $category['categoryname']?></h3>
							<?php 
								$sqlProduct = "SELECT * FROM tbl_product WHERE categoryid = '".$category['categoryid']."' AND inventoryquantity > 0 LIMIT 3";
								$product_with_category_query = pg_query($conn, $sqlProduct);
								if( pg_num_rows( $product_with_category_query ) > 0) {
									foreach($product_with_category_query as $product) { ?>
								<div class="col-md-4 product-men">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item">
											<?php
												$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productid = '".$product['productid']."' LIMIT 1");
												foreach($product_image_query as $product_image){
											?>
											<img src="shared_assets/img/product/<?php echo $product_image['productid']?>/<?php echo $product_image['imagename']?>" alt="" style="width:100%; height:200px;">
											<?php } ?>
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="single.php?id=<?php echo $product['productid']?>" class="link-product-add-cart">Quick View</a>
												</div>
											</div>
										</div>
										<div class="item-info-product ">
											<h4>
												<a href="single.php?id=<?php echo $product['productid']?>"><?php echo $product['productname']?></a>
											</h4>
											<div class="info-product-price">
												<span class="item_price"><?php echo number_format($product['productprice'])?> ??</span>
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="cartxuly.php?id=<?php echo $product['productid']?>" method="post">
													<fieldset>
														<input type="submit" name="submit" value="Add to cart" class="button" />
													</fieldset>
												</form>
											</div>
										</div>
								</div>
							</div>
							<?php 
										}
								}
							?>
							<div class="clearfix"></div>
						</div>
						<!-- //first section (nuts) -->
					</div>
					<?php 		
							}
						}
					?>
				</div>
				<!-- //product right -->
		</div>
	</div>
	<!-- //top products -->
	<script>
		$(document).ready(function(){
			$('#search_text').keyup(function(){
				var txt = $(this).val();
				$('#result').html('');
				$.ajax({
					url:"fetch.php",
					method:"post",
					data:{search:txt},
					dataType:"text",
					success:function(data){
						$('#result').html(data);
					}
				})
			});
		});
	</script>
<?php 
include("include/footer.php");
?>
