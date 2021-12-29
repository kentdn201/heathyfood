<?php
include("../shared_assets/conn.php");
session_start();
$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
if($user) {
    header("Location: index.php");
    die();
}
else {
    if(isset($_POST['Login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM tbl_account WHERE accountUsername = '$username' AND roleID <> 'role_2'";
        $query = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($query);

        if($num_rows>0) {
            while($res = mysqli_fetch_assoc($query)) {
                if(password_verify($password, $res['accountPassword'])) {
                    $_SESSION['user'] = $res;
                    echo "<script type='text/javascript'>alert('Login successfully!')</script>";
                    echo "<script type='text/javascript'>alert('Welcome back, ".$username."')</script>";
                    if($res['roleID']=='role_0') {
                        header("Location: manage_log.php");
                        die();
                    }
                    else {
                        header("Location: manage_inventory.php");
                        die();
                    }
                }
            }
        }
        else {
            echo "<script type='text/javascript'>alert('Login failed!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Brand</title>
    <link rel="stylesheet" href="../shared_assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../shared_assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../shared_assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../shared_assets/fonts/fontawesome5-overrides.min.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Welcome Back!</h4>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="mb-3"><input class="form-control form-control-user" type="text" id="username" aria-describedby="username" placeholder="Enter Username" name="username"></div>
                                        <div class="mb-3"><input class="form-control form-control-user" type="password" id="password" placeholder="Enter Password" name="password"></div>
                                        <button class="btn btn-primary d-block btn-user w-100" type="submit" name="Login">Login</button>
                                        <hr><a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button"><i class="fab fa-google"></i>&nbsp; Login with Google</a>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../shared_assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../shared_assets/js/bs-init.js"></script>
    <script src="../shared_assets/js/theme.js"></script>
</body>

</html>