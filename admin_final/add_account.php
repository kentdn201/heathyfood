<?php 
include("include/header.php");

if($user['roleID'] != 'role_0') { ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">You don't have the sufficient authority to access this page</h3>
    </div>
<?php }
else {

if(isset($_POST['add'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $count = mysqli_num_rows(mysqli_query($conn, "SELECT accountID FROM tbl_account"));
    $not_inserted = true;
    for($i = 0; $i <= $count; $i++) {
        $temp = "account_".$i;
        $res = mysqli_query($conn, "SELECT accountID FROM tbl_account WHERE accountID ='$temp'");
        if(!$res && $not_inserted) {
            $not_inserted = false;
        }
    }
    $accountID = $temp;

    $add_sql = mysqli_query($conn, "INSERT INTO tbl_account(accountID, accountFullname, accountUsername, accountPassword, accountEmail, accountPhone, roleID)
                                    VALUES ('$accountID', '$fullname', '$username', '$password', '$email', '$phone', '$role')");
    if($add_sql) {
        $count = mysqli_num_rows(mysqli_query($conn, "SELECT logID FROM tbl_activity_log"));
        $not_inserted = true;
        for($i = 0; $i <= $count; $i++) {
            $temp = "log_".$i;
            $res = mysqli_query($conn, "SELECT logID FROM tbl_activity_log WHERE logID ='$temp'");
            if(!$res && $not_inserted) {
                $not_inserted = false;
            }
        }
        $logID = $temp;

        $logContent = "Added Account ".$accountID." with the following identifications:
            Fullname: ".$fullname.",
            Username: ".$username.",
            Email: ".$email.",
            Phone Number: ".$phone.",
            Role: ".$role."";

        $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                        VALUES ('$logID', 'Add Account', '$logContent', '".$user['accountID']."')");
        if($log_sql) {
            echo "<script>alert('Add Successful')</script>";
            echo "<script>window.open('manage_account.php','_self')</script>";
        }
    }
    else {
        echo "<script>alert('Add Failed')</script>";
        echo "<script>window.open('manage_account.php','_self')</script>";
    }
}

$role_sql = mysqli_query($conn, "SELECT * FROM tbl_account_role");

?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Add New Account</h3>
                    <div class="row mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Account Information</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="username">
                                                            <strong>Username</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" />
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="password">
                                                            <strong>Password</strong>
                                                        </label>
                                                        <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="full_name">
                                                            <strong>Full Name</strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="fullname" placeholder="Enter Full Name" name="fullname" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email">
                                                            <strong>Email</strong>
                                                        </label>
                                                        <input type="email" class="form-control" id="email" placeholder="user@example.com" name="email" />
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="phone">
                                                            <strong>Phone Number</strong>
                                                        </label>
                                                        <input type="tel" class="form-control" id="phone" placeholder="xxx-xxxxxxx" name="phone" />
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="role">
                                                            <strong>Role</strong>
                                                        </label>
                                                        <select name="role" id="role" class="form-control">
                                                            <option value="0">Select User Role</option>
                                                            <?php foreach($role_sql as $key => $value) { ?>
                                                                <option value="<?php echo $value['roleID'] ?>"><?php echo $value['roleName'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class ="row">
                                                <div class="col">
                                                    <div class="mb-2"><button class="btn btn-primary btn-sm" type="submit" name="add">Add Account</button></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            include("include/footer.php");
            }
            ?>
</body>

</html>