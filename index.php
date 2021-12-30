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
				<?php
					$conn = pg_connect("host=ec2-3-217-170-198.compute-1.amazonaws.com user=epfhbsltcnedlv dbname=d1a3vgbq801lf1 password=3a4dd46548f9a48d9a19bdc2675ac1f01888b0f6a559498566ed31ad7f3330e5");
				    if($conn){
					echo "Thành Công";
				    }
				?>
				<!-- deals -->
				<div class="deal-leftmk left-side">
					<h3 class="agileits-sear-head">Special Deals</h3>
					<?php 
						$deal = pg_query("SELECT * FROM tbl_product LIMIT 6");
						while($row = pg_fetch_array($deal)){
					?>
					<div class="special-sec1">
						<a href="single.php?id=<?php echo $row['productID']?>">
							<div class="col-xs-4 img-deals">
							<?php
								$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productID = '".$row['productID']."' LIMIT 1");
								foreach($product_image_query as $product_image){
							?>
							<img src="shared_assets/img/product/<?php echo $product_image['productID']?>/<?php echo $product_image['imageName']?>" alt="" width="100%">
							<?php } ?>
							</div>
							<div class="col-xs-8 img-deal1">
								<h3><?php echo $row['productName']?></h3>
								<a href="single.php?id=<?php echo $row['productID']?>"><?php echo $row['productPrice']?></a>
							</div>
						<div class="clearfix"></div>
						</a>
					</div>
					<?php } ?>
				</div>
				<!-- //deals -->
			</div>
			<!-- //product left -->
			<!-- product right -->
				<div class="agileinfo-ads-display col-md-9">
					<?php 
						$category_query = pg_query($conn, "SELECT * FROM tbl_product_category");
						foreach($category_query as $category) { 
					?>
					<div class="wrapper">
						<!-- first section (nuts) -->

						<div class="product-sec1">
							<h3 class="heading-tittle"><?php echo $category['categoryName']?></h3>
							<?php 
								$product_with_category_query = pg_query($conn, "SELECT * FROM tbl_product WHERE categoryID = '".$category['categoryID']."' AND inventoryQuantity > 0 LIMIT 3");
								foreach($product_with_category_query as $product) { ?>
								<div class="col-md-4 product-men">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item">
											<?php
												$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productID = '".$product['productID']."' LIMIT 1");
												foreach($product_image_query as $product_image){
											?>
											<img src="shared_assets/img/product/<?php echo $product_image['productID']?>/<?php echo $product_image['imageName']?>" alt="" style="width:100%; height:200px;">
											<?php } ?>
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="single.php?id=<?php echo $product['productID']?>" class="link-product-add-cart">Quick View</a>
												</div>
											</div>
										</div>
										<div class="item-info-product ">
											<h4>
												<a href="single.php?id=<?php echo $product['productID']?>"><?php echo $product['productName']?></a>
											</h4>
											<div class="info-product-price">
												<span class="item_price"><?php echo number_format($product['productPrice'])?> đ</span>
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="cartxuly.php?id=<?php echo $product['productID']?>" method="post">
													<fieldset>
														<input type="submit" name="submit" value="Add to cart" class="button" />
													</fieldset>
												</form>
											</div>
										</div>
								</div>
							</div>
							<?php } ?>
							<div class="clearfix"></div>
						</div>
						<!-- //first section (nuts) -->
					</div>
					<?php } ?>
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
