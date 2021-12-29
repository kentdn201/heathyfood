<?php
    require_once("../shared_assets/conn.php");
    session_start();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $sql = "SELECT * FROM tbl_account_voucher INNER JOIN tbl_voucher_type 
    ON tbl_account_voucher.typeID = tbl_voucher_type.typeID WHERE voucherID = '{$id}'";

    $query = mysqli_query($conn, $sql);

    $action = (isset($_GET['action'])) ? $_GET['action'] : 'add';

    if($query){
        $voucher = mysqli_fetch_assoc($query);
    }
    
    $items = [
        'id' => $voucher['voucherID'],
        'desc' => $voucher['typeDesc'],
        'value' => $voucher['voucherValue'],
        'cost' => $voucher['voucherCost'],
        'type' => $voucher['typeID']
    ];

    // Xử lý bên check out
    if($action == 'add'){
        unset($_SESSION['voucher']);
        $_SESSION['voucher'][$id] = $items;
    }

    if($action == 'delete'){
        unset($_SESSION['voucher']);
    }

    header("location: checkout.php");
?>