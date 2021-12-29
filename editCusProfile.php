<?php 
include("../shared_assets/conn.php");
	include("include/header.php");
	$user = (isset($_SESSION['user']))? $_SESSION['user'] : [];

	if(isset($_POST['update'])){
		$regexPhone = "/^[0-9\-\+]{9,15}$/";
		$regexEmail = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
		$regexPass = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
		if(preg_match($regexEmail,$_POST['email'])){
			if(preg_match($regexPhone,$_POST['phone'])){
				if(preg_match($regexPass,$_POST['newpassword'])){
					$query = "SELECT * FROM tbl_account 
							  WHERE accountUsername = '".$user['accountUsername']."' AND roleID = 'role_2'";
					$res = mysqli_query($conn, $query);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_assoc($res)) {
							if(password_verify($_POST['oldpassword'], $row['accountPassword'])) {
								$userID = $user['accountID'];
								$email = $_POST['email'];
								$phone = $_POST['phone'];
								$password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
								$sql = "UPDATE tbl_account SET accountEmail = '{$email}' ,accountPhone = '{$phone}', accountPassword = '{$password}' WHERE accountID = '{$userID}'";
								$query = mysqli_query($conn, $sql);
								if($query){
									echo "<script>alert('Successfully changed information')</script>";
									echo "<script>window.open('cusprofile.php','_self')</script>";
								} else {
									echo "<script>alert('Change information failed')</script>";
								}
							}
							else {
								echo "<script>alert('Wrong Password')</script>";
							}
						}
					}
				} else {
					echo "<script>alert('You have entered the wrong password format, you must enter at least 8 characters and must have 1 letter and 1 number')</script>";
				}
			} else {
				echo "<script>alert('Phone number must be 10 characters: Eg: 0987654321,...')</script>";
			}
		} else {
			echo "<script>alert('The email to enter has the format like this: Eg: abc@gmail.com,...')</script>";
		}
	}
?>
<style>
	.btn-update{
		padding: 12px 84px;
		color: #fff;
		font-size: 16px;
		background: #1accfd;
		text-decoration: none;
		letter-spacing: 1px;
		display: inline-block;
		font-weight: 800;
		border: none;
	}

	.btn-update:hover{
		background: #2587c8;
		transition: 0.5s all;
		-webkit-transition: 0.5s all;
		-moz-transition: 0.5s all;
		-o-transition: 0.5s all;
		-ms-transition: 0.5s all;
	}
</style>
<div class="container">
	<div class="row gutters">
		<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
			<div class="card h-100">
				<div class="card-body">
					<div class="account-settings">
						<div class="user-profile">
							<h2 style="margin-bottom: 10px">Your Information</h2>
							<h4 class="user-name">Full Name: <?php echo $user['accountFullname']?></h4>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
			<div class="card h-100">
				<div class="card-body">
					<form method="post">
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<h6 class="mb-2 text-primary">Personal Details</h6>
							</div>
							<?php
								$sql = "SELECT * FROM tbl_account WHERE accountID = '{$user['accountID']}'";
								$query = mysqli_query($conn, $sql);
								$showUser = mysqli_fetch_assoc($query);
							?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="phone">Email</label>
									<input type="text" class="form-control" id="phone" name="email" value="<?php echo $showUser['accountEmail']?>" placeholder="Enter your email" required>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $showUser['accountPhone']?>" placeholder="Enter phone number"required>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="password">Old Password</label>
									<input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter Old Pasword" required>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="password">New Password</label>
									<input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Enter New Pasword" required>
								</div>
							</div>
						</div>
						<div class="checkout-right-basket">
							<input type="submit" class="btn-update" name="update" value="Update">
							<a href="cusprofile.php">Cancel
								<span class="far fa-window-close" aria-hidden="true"></span>
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
    include("./include/footer.php");
?>  