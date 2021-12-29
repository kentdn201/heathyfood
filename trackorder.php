<?php
include("../shared_assets/conn.php");
session_start();
if(isset($_POST['check'])) {
    $order = $_POST['order'];
    $phone = $_POST['phone'];
    $sql = "SELECT * FROM tbl_order 
              WHERE orderID = '$order' AND customerPhone = '$phone'";
    $query = pg_query($conn, $sql);
    $checkOrder = pg_num_rows($query);
    if($checkOrder == 1) {
        header("location:orderdetail.php?id=$order");
    }
    else {
        echo "<script>alert('There is no order that you placed')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}
?>