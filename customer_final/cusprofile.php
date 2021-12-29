<?php 
include("include/header.php");
$user = (isset($_SESSION['user']))? $_SESSION['user'] : [];

// $query = mysqli_query($conn, "SELECT * FROM tbl_account WHERE accountID = '$user'");
// $res = mysqli_fetch_assoc($query);

?>
<section>
    <div class="rt-container">
          <div class="col-rt-12">
              <div class="Scriptcontent">
              
<!-- customer Profile -->
<div class="customer-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src="../shared_assets/img/rose1.jpg" alt="Rose">
            <h3><?php echo $user['accountFullname']?></h3>
            
          </div>
          <div class="card-body">
            <!-- <p class="mb-0"><strong class="pr-1"><a href="voucher.php">Voucher</a></strong></p>
            <p class="mb-0"><strong class="pr-1"><a href="">Wallet</a></strong></p>
            <p class="mb-0"><strong class="pr-1"><a href="">Edit Profile</a></strong></p>
            <p class="mb-0"><strong class="pr-1"><a href="">Order History</a></strong></p> -->
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1" ></i>General Information</h3>
          </div>
          <?php
             $sql = "SELECT * FROM tbl_account WHERE accountID = '{$user['accountID']}'";
             $query = mysqli_query($conn, $sql);
             $showUser = mysqli_fetch_assoc($query);
          ?>
          <div class="card-body pt-0">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Username	</th>
                <td><?php echo $showUser['accountUsername']?></td>
              </tr>
              <tr>
                <th width="30%">Phone Number</th>
                <td><?php echo $showUser['accountPhone']?></td>
              </tr>
              <tr>
                <th width="30%">Email	</th>
                <td><?php echo $showUser['accountEmail']?></td>
              </tr>
            </table>
          </div>
        </div>
          <div style="height: 26px"></div>
        
      </div>
      <div class="checkout-right-basket ">
						<a href="voucherCheckOut.php">Voucher
            <span class="fas fa-ticket-alt" aria-hidden="true"></span>
						</a>
            <a href="wallet.php">Wallet
            <span class="fas fa-wallet" aria-hidden="true"></span>
						</a>
            <a href="editCusProfile.php">Edit Profile
            <span class="fas fa-user" aria-hidden="true"></span>
						</a>
            <a href="history.php">Order History
            <span class="fas fa-history" aria-hidden="true"></span>
						</a>
			</div>
  </div>
</div>
<!-- partial -->
    		</div>
		</div>
    </div>
</section>
<?php 
include("include/footer.php");
?>