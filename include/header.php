<?php
include("../shared_assets/conn.php");
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Online Shop</title>
	<!--/tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Grocery Shoppy Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--//tags -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<link href="../shared_assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../shared_assets/css/style_user.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../shared_assets/css/font-awesome.css" rel="stylesheet">

	<!--pop-up-box-->
	<link href="../shared_assets/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
	<!--//pop-up-box-->

	<!-- price range -->
	<link rel="stylesheet" type="text/css" href="../shared_assets/css/jquery-ui1.css">

	<!-- flexslider -->
	<link rel="stylesheet" href="../shared_assets/css/flexslider.css" type="text/css" media="screen" />


	<!-- fonts -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
	<!-- Cusprofile -->
	<link rel="stylesheet" href="../shared_assets/css/cusprofile.css"/>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
	<!-- voucher -->
	<!-- <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'> -->
	<link rel="stylesheet" href="../shared_assets/css/voucher.css" />
	<link rel="stylesheet" href="../shared_assets/css/wallet.css" />
	<link rel="stylesheet" href="../shared_assets/css/getVoucher.css" />
	<link rel="stylesheet" href="../shared_assets/css/editCus.css" />
</head>
<body>
	<?php 
		session_start();
		$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
	?>
	<!-- top-header -->
	<div class="header-most-top">
		<p>===================Just Buy Something You Need===================</p>
	</div>
	<!-- //top-header -->
	<style>
		.error{
			color: red;
		}
	</style>
	<!-- header-bot-->
	<div class="header-bot">
		<div class="header-bot_inner_wthreeinfo_header_mid">
			<!-- header-bot-->
			<div class="col-md-4 logo_agile">
				<h1>
					<a href="index.php">
						<!-- <span>S</span>KT
						<span>T</span>1 -->
						<img src="../shared_assets/img/c9.png" alt=" " style="width: 115px;height: 100px;">
					</a>
				</h1>
			</div>
			<!-- header-bot -->
			<div class="col-md-8 header">
				<!-- header lists -->
				<ul>
					<li>
						<a href="#" data-toggle="modal" data-target="#trackOrder">
							<span class="fa fa-truck" aria-hidden="true"></span>Track Order</a>
					</li>
					<li>
						<span class="fa fa-phone" aria-hidden="true"></span> 001 234 5678
					</li>
					<?php
						if($user) { ?>
						<li>
							<a href="cusprofile.php" >
							<span class="fas fa-user" aria-hidden="true"></span>My Account</a>
						</li>
						<li>
							<a href="logout.php" >
							<span class="fas fa-user" aria-hidden="true"></span>Log Out</a>
						</li>
					<?php } 
					else { ?>
						<li>
							<a href="#" data-toggle="modal" data-target="#signIn">
								<span class="fa fa-unlock-alt" aria-hidden="true"></span> Sign In </a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#signUp">
								<span class="fa fa-pencil-square-o" aria-hidden="true"></span> Sign Up </a>
						</li>
					<?php } ?>
				</ul>
				<!-- //header lists -->

				<!-- search -->
				<div class="agileits_search">
					<form action="search.php" method="get">
						<input name="search" id="search" type="search" placeholder="How can we help you today?">
						<button type="submit" class="btn btn-default" aria-label="Left Align">
							<span class="fa fa-search" aria-hidden="true"> </span>
						</button>
					</form>
				</div>
				<!-- //search -->

				<!-- cart details -->
				<div class="top_nav_right">
					<div class="wthreecartaits wthreecartaits2 cart cart box_1">
						<form action="cart.php" method="post" class="last">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="display" value="1">
							<button class="w3view-cart" type="submit" name="submit" value="" >
								<i class="fa fa-cart-arrow-down" aria-hidden="true" ></i>
							</button>
						</form>
					</div>
				</div>
				<!-- //cart details -->
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<!-- signIn -->
	<div class="modal fade" id="trackOrder" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-sub_agile">
					<div class="main-mailposi">
						<span class="fa fa-envelope-o" aria-hidden="true"></span>
					</div>
					<div class="modal_body_left modal_body_left1">
						<h3 class="agileinfo_sign">Track Order </h3>
						<p>
							Input your Order ID and your phone number
						</p>
						<form action="trackorder.php" method="post" id="sign_in_form" name="sign_in_form">
							<div class="styled-input agile-styled-input-top">
								<input type="text" placeholder="Order ID" name="order" id="order" required>
							</div>
							<div class="styled-input">
								<input type="text" placeholder="Phone Number" name="phone" id="phone" required>
							</div>
							<button class= "btn" name="check"><img>Check</button>
						</form>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- //Modal content-->
		</div>
	</div>
	<!-- //signIn -->

	<!-- signin Model -->
	<!-- signIn -->
	<div class="modal fade" id="signIn" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-sub_agile">
					<div class="main-mailposi">
						<span class="fa fa-envelope-o" aria-hidden="true"></span>
					</div>
					<div class="modal_body_left modal_body_left1">
						<h3 class="agileinfo_sign">Sign In </h3>
						<p>
							Sign In now, Let's start your Grocery Shopping. Don't have an account?
							<a href="#" data-toggle="modal" data-target="#signUp">
								Sign Up Now</a>
						</p>
						<form action="login.php" method="post" id="sign_in_form" name="sign_in_form">
							<div class="styled-input agile-styled-input-top">
								<input type="text" placeholder="User Name" name="name" id="name" required>
							</div>
							<div class="styled-input">
								<input type="password" placeholder="Password" name="password" id="password" required>
							</div>
							<button class= "btn" name="Login"><img> Sign In</button>
							<!-- <input type="submit" value="Sign In">
							<input type="submit"  value=" Google"> -->
							<button class= "btn-google" name="Google"><i class="fab fa-google"></i> Google</button>
						</form>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- //Modal content-->
		</div>
	</div>
	<!-- //signIn -->
	<!-- //signin Model -->

	<!-- signup Model -->
	<!-- signUp -->
	<div class="modal fade" id="signUp" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-sub_agile">
					<div class="main-mailposi">
						<span class="fa fa-envelope-o" aria-hidden="true"></span>
					</div>
					<div class="modal_body_left modal_body_left1">
						<h3 class="agileinfo_sign">Sign Up</h3>
						<p>
							Come join the Grocery Shoppy! Let's set up your Account.
						</p>

						<form action="signup.php" method="post">
							<form >
								<div class="styled-input agile-styled-input-top form-group">
									<input type="text" placeholder="Full Name" name="name" id="name" autofocus required>
								</div>

								<div class="styled-input agile-styled-input-top form-group">
									<input type="text" placeholder="Username" name="user" id="user" required>
									<span class="form-message"></span>
								</div>

								<div class="styled-input form-group">
									<input type="text" placeholder="E-mail" name="email" id="email" required>
									<span class="form-message"></span>
								</div>
								
								<div class="styled-input form-group">
									<input type="text" placeholder="Phone Number" name="phone" id="phone" required>
									<span class="form-message"></span>
								</div>

								<div class="styled-input form-group">
									<input type="password" placeholder="Password" name="password" id="password" required> 
									<span class="form-message"></span>
								</div>
								<input type="submit" name="signUp" value="Sign Up">
							</form>
						</form>
					</div>
				</div>
			</div>
			<!-- //Modal content-->
		</div>
	</div>
	<!-- //signUp -->
	<!-- //signup Model -->

	<!-- //header-bot -->

	<!-- navigation -->
	<div class="ban-top">
		<div class="container">
			<div class="top_nav_left">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
							    aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav menu__list">
								<li class="">
									<a class="nav-stylehead" href="index.php">Home
									</a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle nav-stylehead" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu multi-column columns-3">
										<div class="agile_inner_drop_nav_info">
											<div class="col-sm-8 multi-gd-img">
												<ul class="multi-column-dropdown">
													<?php
														$category_query = pg_query($conn, "SELECT * FROM tbl_product_category");
														foreach($category_query as $row) { ?>
															<li>
																<a href="product.php?id=<?php echo $row['categoryID']?>"><?php echo $row['categoryName']?></a>
															</li>
													<?php } ?>
												</ul>
											</div>
											<div class="col-sm-4 multi-gd-img">
												<img src="../shared_assets/img/nav.png" alt="">
											</div>
											<div class="clearfix"></div>
										</div>
									</ul>
								</li>
								<li class="">
									<a class="nav-stylehead" href="contact.php">Contact</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>