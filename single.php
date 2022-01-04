<?php
	include("include/header.php");
?>
<?php
	if(isset($_POST['comment'])){
		$regexName = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
		$regexUser = "/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
		$regexPhone = "/^[0-9\-\+]{9,15}$/";
		$regexEmail = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
		if(preg_match($regexName,$_POST['commentUser'])){
			if(preg_match($regexEmail,$_POST['commentEmail'])){
				if(preg_match($regexPhone,$_POST['commentPhone'])){
					$id = 'comment'.rand(100, 900000);
					$commentUser = $_POST['commentUser'];
					$commentContent = $_POST['commentContent'];
					$commentPhone = $_POST['commentPhone'];
					$commentEmail = $_POST['commentEmail'];
					$productID = $_POST['productID'];

					$sql = "INSERT INTO tbl_product_comment (commentID, commentUser, commentContent, commentPhone, commentEmail, productID) 
					VALUES ('$id', '$commentUser', '$commentContent', '$commentPhone', '$commentEmail', '$productID')";

					$query = pg_query($conn, $sql);
					if($query){
						echo "<script>alert('Thank you for leaving your comment')</script>";
					}
				} else {
					echo "<script>alert('Phone number must be 10 characters: Eg: 0987654321,...')</script>";
				}
			} else {
				echo "<script>alert('The email to enter has the format like this: Eg: abc@gmail.com,...')</script>";
			}
		} else {
			echo "<script>alert('The input name must have the format like this: Eg: John, Nguyen A,....')</script>";
		}
	}
?>
<style>
	.soluong {
		width: 40px;
		border-radius: 3px;
		border: 1px solid gray;
		margin-bottom: 10px;
	}

	.ratingOfUser{
    width: 94%;
    padding-top: 8px;
    padding-bottom: 40px;
    padding-left: 5%;
    padding-right: 10%;
    margin-left: 100px;
  }
  
  .heading {
    font-size: 25px;
    margin-right: 25px;
  }
  
  .fa {
    font-size: 25px;
  }
  
  .checked {
    color: orange;
  }
  
  /* Three column layout */
  .side {
    float: left;
    width: 15%;
    margin-top:10px;
  }
  
  .middle {
    margin-top:10px;
    float: left;
    width: 70%;
  }
  
  /* Place text to the right */
  .right {
    text-align: right;
  }
  
  /* Clear floats after the columns */
  .row-rating:after {
    content: "";
    display: table;
    clear: both;
  }
  
  /* The bar container */
  .bar-container {
    width: 100%;
    background-color: #f1f1f1;
    text-align: center;
    color: white;
  }
  
  /* Individual bars */
  .bar-5 {width: 60%; height: 18px; background-color: #04AA6D;}
  .bar-4 {width: 30%; height: 18px; background-color: #2196F3;}
  .bar-3 {width: 10%; height: 18px; background-color: #00bcd4;}
  .bar-2 {width: 4%; height: 18px; background-color: #ff9800;}
  .bar-1 {width: 15%; height: 18px; background-color: #f44336;}
  
  /* Responsive layout - make the columns stack on top of each other instead of next to each other */
  @media (max-width: 400px) {
    .side, .middle {
      width: 100%;
    }
    .right {
      display: none;
    }
  }
  
  @media screen and (max-width: 600px) {
    .productFeedback,
    .ratingOfUser{
        width: 100%;
    }
  }


  .medium-container{
    max-width: 1280px;
    margin: auto;
    padding-left: 25px;
    padding-right: 25px;
  }
  
  .display{
    display: block;
  }

.productFeedback{
    width: 94%;
    padding-top: 8px;
    padding-bottom: 40px;
    padding-left: 5%;
    padding-right: 10%;
    margin-left: 100px;
  }
  
  .productFeedback h2{
    display: block;
    border-left: #1accfd 4px solid;
    padding-left: 5px;
    font-size: 20px;
  }
  
  .productFeedback .input-feedback{
    padding: 5px;
    width: 100%;
  }
  
  .productFeedback .input-space{
    margin-bottom: 12px;
    margin-top: 12px;
    width: 5px;
  }
  
  .productFeedback .input-user{
    display: inline-block;
    margin-right: 10px;
    height: 48px;
    min-height: 48px;
    max-height: 48px;
    text-indent: 10px;
    width: 100%;
    margin-bottom: 5px;
  }
  
  .productFeedback .input-description{
    display: inline-block;
    width: 100%;
    height: 140px;
    margin-right: 10px;
    text-indent: 10px;
    margin-top: 5px;
  }
  
  .productFeedback .btn-submit{
    width: 100%;
    height: 48px;
    color: #fff ;
    background: #1accfd;
    border-radius: 6px;
    text-transform: uppercase;
    
  }
  
  .productFeedback .user-feedback {
    border-bottom: gray 1px solid;
    padding: 10px 0 5px;
    position: block;
  }
  
  .productFeedback .feedback-form{
    width: 100%;
    height: 50%;
    border: .5px solid #1accfd;
    border-radius: 5px;
    margin-top: 10px;
    margin-bottom: 4px;
  }
  .user-feedback b{
    font-size: 24px;
    display: block;
    margin-bottom: 3px;
  }
</style>
<!-- //banner-2 -->
	<!-- page -->
	<div class="services-breadcrumb">
		<div class="agile_inner_breadcrumb">
			<div class="container">
				<ul class="w3_short">
					<li>
						<a href="index.php">Home</a>
						<i>|</i>
					</li>
					<li>Single Page</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->

	<!-- Single Page -->
	<div class="banner-bootom-w3-agileits">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l">Single Page
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
			<div class="col-md-5 single-right-left ">
				<?php

					$id = $_GET["id"]; // Get ID
					$sql = "SELECT * FROM tbl_product WHERE productID = '{$id}';"; // sql command
					$result = pg_query($conn, $sql);

					// Start While loop
					$row = pg_fetch_assoc($result);
				?>
				<div class="grid images_3_of_2">
					<div class="flexslider">
						<ul class="slides">
							<?php
								$id = $_GET["id"];
								$sql = "SELECT * FROM tbl_product_images WHERE productid = '{$id}' LIMIT 3";
								$query = pg_query($conn, $sql);

								while($image = pg_fetch_assoc($query)){
							?>
							<li data-thumb="../shared_assets/img/product/<?php echo $image['productid']?>/<?php echo $image['imagename']?>">
								<div class="thumb-image">
									<img src="../shared_assets/img/product/<?php echo $image['productid']?>/<?php echo $image['imagename']?>" data-imagezoom="true" class="img-responsive" alt="">
								</div>
							</li>
							<?php } ?>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="col-md-7 single-right-left simpleCart_shelfItem">
				<h3>
					<?php echo $row['productname']?>
				</h3>
				<p>
					<span class="item_price"><?php echo $row['productprice']?> VND</span>
				</p>
				<div class="occasion-cart">
					<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
						<?php
							if($row['inventoryquantity'] > 0){
						?>
						Quantity in stock: <?php echo $row['inventoryquantity']?>
						<form action="cartxuly.php" method="GET">
							<fieldset>
								<input type="hidden" name="id" value="<?php echo $row['productid']?>" />
								Quantity:
								<input type="number" class="soluong" value="1" name="quantity"/>
								<input type="submit" name="addcart" value="Add to cart" class="button" />
							</fieldset>
						</form>
					</div>
				</div>
				<div class="single-infoagile" style="margin-top:10px;">
					<ul>
						<li>
							Cash on Delivery Eligible.
						</li>
						<li>
							Shipping Speed to Delivery.
						</li>
					</ul>
				</div>
						<?php
							} else {
								echo 'Out of stock';
							}
						?>
				<div class="product-single-w3l">
					<p>
						<i class="fa fa-hand-o-right" aria-hidden="true"></i>Product Description
						<ul>
							<li>
								<?php echo $row['productdesc']?>
							</li>
						</ul>
					</p>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!-- User feedback -->
	<div class="productFeedback">
		<h2>Comment</h2>
		<form method="POST">
			<div class="input-feedback">
				<textarea type ="text" cols="5" rows="5" class="input-description" placeholder="Input your feedback" name="commentContent" required></textarea>
				<input type="text" class="input-user" placeholder="Input name" name="commentUser" required>
				<input type="text" class="input-user" placeholder="Input phone number" name="commentPhone" required>
				<input type="email" class="input-user" placeholder="Input Email" name="commentEmail" required>
				<input type="hidden" class="input-user" value="<?php echo $row['productID']?>" name="productID">
				<button type="submit" name="comment" class="btn-submit">Comment</button>
			</div>
		</form>
		<?php
			$sql = "SELECT * FROM tbl_product_comment WHERE productID = '{$row['productid']}' ORDER BY createdTime DESC";
			$query = pg_query($conn, $sql);
			if(pg_num_rows($query) > 0){
				while($comment = pg_fetch_assoc($query)){	 
		?>
				<div class="user-feedback">
					<b>
						User: <?php echo $comment['commentuser']?>
					</b>
					<p class="cUser-feedback">
						<?php echo $comment['createdtime']?>
					</p>
					<p class="cUser-feedback">
						<?php echo $comment['commentcontent']?>
					</p>
				</div>
		<?php

				} // end while

			} else {
		?>
		<h4 style="text-align: center; font-size: 18px; margin-top: 20px;">The product has no reviews yet, please leave your review about our products</h4>
		<?php
			}
		?>

	</div>
	<!-- //User feedback -->
	<!-- //Single Page -->

	<!-- special offers -->
	<div class="featured-section" id="projects">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l">Add More
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
				<div class="content-bottom-in">
					<ul id="flexiselDemo1">
					<?php
						$sql = "SELECT * FROM tbl_product WHERE categoryid = '{$row['categoryid']}'";
						$query = pg_query($conn, $sql);
						while($row = pg_fetch_array($query)){
					?>
						<li>
							<div class="w3l-specilamk">
								<div class="speioffer-agile">
									<a href="single.php?id=<?php echo $row['productid']?>">
									<?php
										$product_image_query = pg_query($conn, "SELECT * FROM tbl_product_images WHERE productid = '".$row['productid']."' LIMIT 1");
										foreach($product_image_query as $product_image){
									?>
									<img src="../shared_assets/img/product/<?php echo $product_image['productid']?>/<?php echo $product_image['imagename']?>" alt="" style="width:100%; height:250px;>
									<?php } ?>
									</a>
								</div>
								<div class="product-name-w3l">
									<h4>
										<a href="single.php?id=<?php echo $row['productID']?>"><?php echo $row['productname']?></a>
									</h4>
									<div class="w3l-pricehkj">
										<?php
										if($row['inventoryquantity'] > 0) { ?>
											<h6><?php echo number_format($row['productprice'])?> VND</h6>
										<?php }
										else { ?>
											<h6>Out of Stock</h6>
										<?php }
										?>
									</div>
									<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
									<form action="cartxuly.php" method="GET">
										<fieldset>
											<input type="hidden" name="id" value="<?php echo $row['productid']?>" />
											<input type="hidden" class="soluong" value="1" name="quantity"/>
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
						</li>
						<?php } ?>
					</ul>
				</div>
		</div>
	</div>
	<!-- //special offers -->
<?php
include("include/footer.php");	
?>
