<?php
include("../shared_assests/conn.php");
session_start();

$detail = $_POST['details'];
if($detail['status']=="COMPLETED") {
    unset($_SESSION['paypal']);
    $_SESSION['paypal'] = $detail;
}

?>