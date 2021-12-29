<?php
include("../shared_assets/conn.php");
session_start();
$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
if(!$user) {
    header("Location: login.php");
    die();
}
?>
<!DOCTYPE html>
<html>

<!--Header-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Brand Name</title>
    <link rel="stylesheet" href="../shared_assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../shared_assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../shared_assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../shared_assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../shared_assets/css/style_admin.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<!--/Header-->

<!--Body-->
<body id="page-top">
    <div id="wrapper">
        <!--Side Navbar-->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0 sidebar-l">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fas fa-laugh-wink"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">
                        <span>Brand</span>
                    </div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light nav-links" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="manage_log.php"><i class="fas fa-scroll"></i><span>Activity Log</span></a></li>
                    <?php
                    if($user['roleID']=='role_0') { ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="#">
                                <i class="fa fa-users"></i><span>Account Management </span>
                                <i class="fa fa-angle-down arrow" style="float: right;"></i>
                            </a>
                            <ul class="navbar-nav text-light sub-menu">
                                <li class="nav-item"><a class="nav-link" href="manage_account.php" ><i class="fa fa-user"></i> Manage Account</a></li>
                                <li class="nav-item"><a class="nav-link" href="manage_role.php" ><i class="fas fa-user-tag"></i> Manage Role</a></li>
                            </ul>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="#">
                                <i class="fas fa-boxes"></i><span>Product Management </span>
                                <i class="fa fa-angle-down arrow" style="float: right;"></i>
                            </a>
                            <ul class="navbar-nav text-light sub-menu">
                                <li class="nav-item"><a class="nav-link" href="manage_product.php" ><i class="fas fa-box"></i> Manage Product</a></li>
                                <li class="nav-item"><a class="nav-link" href="manage_category.php" ><i class="fas fa-box-open"></i> Manage Product Category</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="manage_inventory.php"><i class="fa fa-dropbox"></i><span>Inventory Management</span></a></li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-invoice"></i><span>Invoice Management </span>
                            <i class="fa fa-angle-down arrow" style="float: right;"></i>
                        </a>
                        <ul class="navbar-nav text-light sub-menu">
                            <li class="nav-item"><a class="nav-link" href="manage_order.php" ><i class="fas fa-file-invoice-dollar"></i> Manage Order</a></li>
                            <li class="nav-item"><a class="nav-link" href="manage_payment.php" ><i class="fas fa-credit-card"></i> Manage Payment</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="manage_voucher.php"><i class="fa fa-shopping-bag"></i><span>Voucher Management</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <!--/Side Navbar-->

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <!--Navbar-->
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow">
                                <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                    <i class="fas fa-search"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group">
                                            <input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary py-0" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                        <span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $user['accountUsername']?></span>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" href="logout.php">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!--Navbar-->