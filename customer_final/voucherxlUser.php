<?php
    require_once("../shared_assets/conn.php");
    session_start();
    
    $user = (isset($_SESSION['user']))? $_SESSION['user'] : [];

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $action = (isset($_GET['action'])) ? $_GET['action'] : 'add';

    // Xử lý bên user
    if($action == 'add') {
        $query = mysqli_query($conn, "SELECT * FROM tbl_voucher_type WHERE typeID = '{$id}'");
        $fetch = mysqli_fetch_assoc($query);
        if($query) {
            $_SESSION['voucher'] = $fetch;
            $voucher = (isset($_SESSION['voucher']))? $_SESSION['voucher'] : [];
            $user = $user['accountID'];

            // Thực hiên lấy số coin hiện tại để so sánh với giá của voucher đó
            $sqlUser = "SELECT * FROM tbl_account_wallet WHERE accountID = '{$user}'";
            $queryUser = mysqli_query($conn, $sqlUser);
            $rowUser = mysqli_fetch_assoc($queryUser);

            // Nếu số coin hiện tại lớn hơn giá của voucher thì sẽ tiến hành thêm vào
            if($rowUser['walletBalance'] >= $voucher['voucherCost']){
                $id = 'voucher'.rand(0, 999999);
                $type = $voucher['typeID'];
                // SQL thêm một voucher vào tài khoản
                $sql = "INSERT INTO tbl_account_voucher (voucherID, accountID, typeID) VALUES ('$id', '$user', '$type')";
                $query = mysqli_query($conn, $sql);
                if($query){
                    // Tiến hành trừ đi số coin vừa đổi
                    $coin = $rowUser['walletBalance'] - $voucher['voucherCost'];
                    $sqlUpdate = "UPDATE tbl_account_wallet SET walletBalance = '{$coin}' WHERE accountID = '{$user}'";
                    $queryUpdate = mysqli_query($conn, $sqlUpdate);
                    if($queryUpdate){
                        // Lưu vào lịch sử khi trừ đi số coin vừa đổi voucher
                        $walletID = $rowUser['walletID'];
                        $coin = $voucher['voucherCost'];
                        $name = 'Redeem voucher';
                        $sqlHistory = "INSERT INTO tbl_wallet_history (historyName, historyAmount, walletID) 
                        VALUES ('$name', '$coin', '$walletID')";
                        $queryHistory = mysqli_query($conn, $sqlHistory);
                        if($queryHistory){
                              
                            echo "<script>alert('Redeem voucher success')</script>";
                            unset($_SESSION['voucher']);
                            echo "<script>window.open('voucherCheckOut.php','_self')</script>";
                        } else {
                            echo "<script>alert('failed cuối')</script>";
                            echo "<script>window.open('getVoucher.php','_self')</script>";
                        }
                    } else {
                        echo "<script>alert('failed gần cuối')</script>";
                        echo "<script>window.open('getVoucher.php','_self')</script>";
                    }
                } else {
                    echo "<script>alert('failed gần gần cuối')</script>";
                    echo "<script>window.open('getVoucher.php','_self')</script>";
                }
            } else {
                echo "<script>alert('Your coin is not enough to get voucher')</script>";
                echo "<script>window.open('getVoucher.php','_self')</script>";
            }
        }
        else {
            echo "<script>alert('failed đầu')</script>";
            echo "<script>window.open('getVoucher.php','_self')</script>";
        }
    }

?>